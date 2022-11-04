<?php

namespace Marssilen\Statistic\Console\Commands;

use Illuminate\Console\Command;
use Marssilen\Flashcard\Repositories\FlashcardRepository;
use Marssilen\Practice\Repositories\PracticeRepository;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'flashcard:stats')]
class StatsCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flashcard:stats';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the stats';

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
     * Display the following stats:
     * - The total amount of questions.
     * - % of questions that have an answer.
     * - % of questions that have a correct answer.
     */
    public function handle()
    {
        $this->drawTable();
    }

    /**
     * Draw Table
     */
    private function drawTable()
    {
        $headers = [
            'The total amount of questions',
            '% of questions that have an answer',
            '% of questions that have a correct answer'
        ];

        $numberOfAllFlashcards = $this->flashcardRepository->countAllFlashcard();

        $numberOfAllFlashcardsWithOneAnswer =
            $this->practiceRepository->calculatePercentOfQuestionsWithAnswer();

        $numberOfAllFlashcardsWithCorrectAnswer =
            $this->practiceRepository->calculateProgress();

        $data = [
            [
                $numberOfAllFlashcards,
                $numberOfAllFlashcardsWithOneAnswer,
                $numberOfAllFlashcardsWithCorrectAnswer
            ]
        ];

        $this->table($headers, $data);
    }
}
