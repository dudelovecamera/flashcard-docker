<?php

namespace Marssilen\Practice\Console\Commands;

use Illuminate\Console\Command;
use Marssilen\Flashcard\Repositories\FlashcardRepository;
use Marssilen\Practice\Repositories\PracticeRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;

#[AsCommand(name: 'flashcard:practice')]
class PracticeCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flashcard:practice';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:practice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Answer a question';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        protected FlashcardRepository $flashcardRepository,
        protected PracticeRepository $practiceRepository
    ) {
        parent::__construct();
    }

    /**
     * Answer question
     */
    public function handle()
    {
        while ($input = $this->validate($this->getInput())) {
            $this->practice($input);
        }
    }

    private function validate($id): int
    {
//        check whether it is in range of ids
//        check if it is not already answered by this user
//        it must be a number
        return $id;
    }

    private function getInput()
    {
        $this->showOptions();

        $command = $this->ask('Select one of the questions or enter "exit"');
        if ($command == 'exit') {
            return 0;
        }
        return $command;
    }

    private function showOptions(): void
    {
        $data = $this->practiceRepository->getAllQuestionsWithAnswerStatus();
        $progress = $this->practiceRepository->calculateProgress();
        $this->drawTable($data, $progress);
    }

    private function practice($id)
    {
        $flashcard = $this->flashcardRepository->findOrFail($id);

        $check = $this->checkPreviousHistory($id, null);
        if ($check) {
            $this->warn('already answered');
            return;
        }

        $this->info('question is: ' . $flashcard->question);
        $answer = $this->ask('Please enter the answer');

        $isCorrect = $answer == $flashcard->answer;
        $this->printResultMessage($isCorrect);

        event('marssilen.practice.answer.after', [$id, $answer, $isCorrect]);
    }

    private function checkPreviousHistory(int $flashcardId, $userId): bool
    {
        return $this->practiceRepository->isAlreadyAnswered($flashcardId, $userId);
    }

    private function drawTable($data, $progress)
    {
        $table = new Table($this->output);

        // Set the table headers.
        $table->setHeaders(['Id', 'Question', 'Status']);
        $data = $this->addFooter($data, $progress);

        // Set the contents of the table.
        $table->setRows($data);

        // Render the table to the output.
        $table->render();
    }

    private function addFooter(&$data, $progress): array
    {
        return array_merge($data, [
            new TableSeparator,
            [
                new TableCell('Progress', ['colspan' => 2]),
                new TableCell("$progress%", ['colspan' => 1])
            ]
        ]);
    }

    private function printResultMessage($isCorrect)
    {
        $isCorrect ? $this->info('correct') : $this->warn('incorrect');
    }
}
