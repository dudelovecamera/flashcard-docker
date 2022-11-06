<?php

namespace Marssilen\Practice\Console\Commands;

use Illuminate\Console\Command;
use Marssilen\Flashcard\Repositories\FlashcardRepository;
use Marssilen\Practice\Repositories\PracticeRepository;
use Marssilen\Practice\Traits\FlashcardChoiceQuestion;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'flashcard:practice')]
class PracticeCommand extends Command
{
    use FlashcardChoiceQuestion;
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
        while ($input = $this->getInput()) {
            $this->practice($input);
        }
    }

    private function getInput(): int
    {
        $data = $this->practiceRepository->getAllQuestionsWithAnswerStatus();
        $progress = $this->practiceRepository->calculateProgress();

        return $this->askChoiceQuestion($data, $progress);
    }

    private function practice($id)
    {
        $flashcard = $this->flashcardRepository->findOrFail($id);

        $check = $this->checkPreviousHistory($id, null);
        if ($check) {
            $this->warn('already answered');
            return;
        }

        $this->info('question is: '.$flashcard->question);
        $answer = $this->ask('Please enter the answer');

        $isCorrect = $answer == $flashcard->answer;
        $this->printResultMessage($isCorrect);

        event('marssilen.practice.answer.after', [$id, $answer, $isCorrect]);
    }

    private function checkPreviousHistory(int $flashcardId, $userId): bool
    {
        return $this->practiceRepository->isAlreadyAnswered($flashcardId, $userId);
    }

    private function printResultMessage($isCorrect)
    {
        $isCorrect ? $this->info('correct') : $this->warn('incorrect');
    }
}
