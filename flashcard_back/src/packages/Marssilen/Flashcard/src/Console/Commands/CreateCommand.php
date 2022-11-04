<?php

namespace Marssilen\Flashcard\Console\Commands;

use Illuminate\Console\Command;
use Marssilen\Flashcard\Repositories\FlashcardRepository;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'flashcard:create')]
class CreateCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flashcard:create';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create flashcard with question and answer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected FlashcardRepository $flashcardRepository,
    ) {
        parent::__construct();
    }

    /**
     * start command
     * @return void
     */
    public function handle()
    {
        $this->createFlashCard();

        $this->info('New flashcard created');
    }

    /**
     * Create a new flashcard
     * @return void
     */
    private function createFlashCard()
    {
        $this->flashcardRepository->create($this->getInput());
    }

    /**
     * get inputs from user
     * @return array
     */
    private function getInput(): array
    {
        $question = $this->ask('Please enter the question');
        $answer = $this->ask('Please enter the answer');

        return compact('question', 'answer');
    }
}
