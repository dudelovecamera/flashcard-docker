<?php

namespace Marssilen\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'flashcard:interactive')]
class InteractiveCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flashcard:interactive';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'An interactive artisan command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        do {
            $allCommands = $this->getAllCommands();

            $groupedCommands = $this->getGroupedCommands($allCommands);

            $group = $this->getFlashcardCommandGroup();

            $commands = $this->getCommandsForGroup($groupedCommands, $group);

            $command = $this->askForCommand($commands);

            $signature = $this->getCommandSignature($group, $command);

        } while ($this->callCommand($signature) != -1);
    }

    /**
     * Get all available command for this application.
     *
     * @return Collection
     */
    protected function getAllCommands(): Collection
    {
        $app = $this->getApplication();
        return collect($app->all());
    }

    /**
     * Group command using the prefix before the : in the signature.
     *
     * @param  Collection  $commands
     * @return Collection
     */
    protected function getGroupedCommands(Collection $commands): Collection
    {
        return $commands->map(function ($item) {
            $signature = explode(':', $item->getName());
            return [
                'group' => $signature[0],
                'command' => $signature[1] ?? '',
                'description' => $item->getDescription()
            ];
        })->groupBy('group')->sortKeys();
    }

    /**
     * Ask the user to select the command group they want to run a command from.
     *
     * @return string
     */
    protected function getFlashcardCommandGroup(): string
    {
        return 'flashcard';
    }

    /**
     * Return all commands for a specific group.
     *
     * @param  Collection  $commands
     * @param  string  $group
     * @return Collection
     */
    protected function getCommandsForGroup(Collection $commands, string $group): Collection
    {
        return $this->addExitCommand($this->removeInteractiveCommand($commands[$group]));
    }

    /**
     * Remove interactive command from the list.
     *
     * @param  Collection  $commands
     * @return Collection
     */
    private function removeInteractiveCommand(Collection $commands): Collection
    {
        return $commands->forget(0);
    }

    /**
     * Add exit command to the collection
     *
     * @param  Collection  $commands
     * @return Collection
     */
    private function addExitCommand(Collection $collection): Collection
    {
        return $collection->push(['group' => 'flashcard', 'command' => 'exit', 'description' => 'Exit from the app']);
    }


    /**
     * Ask the user to select a specific command to run.
     *
     * @param  Collection  $commands
     * @return string
     */
    protected function askForCommand(Collection $commands): string
    {
        return $this->choice(
            'Which command would you like to run?',
            $commands
                ->keyBy('command')->map(function ($item) {
                    return $item['description'];
                })->all()
        );
    }

    /**
     * Generate the command signature based on the group and command.
     *
     * @param  string  $group
     * @param  string  $command
     * @return string
     */
    protected function getCommandSignature(string $group, string $command): string
    {
        $prefixedCommand = $command ? ":{$command}" : $command;

        return "{$group}{$prefixedCommand}";
    }

    /**
     * Call the command based on the user input given.
     *
     * @param  string  $signature
     * @return int
     */
    protected function callCommand(string $signature): int
    {
        if ($signature == 'flashcard:exit') {
            return -1;
        }
        return $this->call($signature);
    }
}
