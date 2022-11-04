<?php

namespace Marssilen\Practice\Repositories;

use Illuminate\Container\Container as Application;
use Marssilen\Core\Eloquent\Repository;
use Marssilen\Flashcard\Repositories\FlashcardRepository;

class PracticeRepository extends Repository
{

    public function __construct(Application $app, protected FlashcardRepository $flashcardRepository)
    {
        parent::__construct($app);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'Marssilen\Practice\Contracts\Answer';
    }

    public function createAnswer($flashcard_id, $answer, $is_correct)
    {
        $this->getModel()->create(compact('flashcard_id', 'answer', 'is_correct'));
    }

    public function isAlreadyAnswered($flashcardId, $userId): bool
    {
        return ($this->getModel()->where('user_id', $userId)
                ->where('flashcard_id', $flashcardId)
                ->where('is_correct', true)->get()->count()) > 0;
    }

    public function getAllQuestionsWithAnswerStatus(): array
    {
        $data = collect($this->flashcardRepository->getModel()->select('id', 'question')->with('last_answer')->get());
        $newData = $data->map(function ($flashcard) {
            $flashcard->status = $this->getStatus($flashcard->last_answer);
            unset($flashcard->last_answer);
            return $flashcard;
        });

        return $newData->toArray();
    }

    private function getStatus($input): string
    {
        if (!$input) {
            return 'not answered';
        }

        switch ($input->is_correct) {
            case '1':
                return 'correct';
            default:
                return 'incorrect';
        }
    }

    public function calculatePercentOfQuestionsWithAnswer(): int
    {
        $numberOfAllFlashcards = $this->flashcardRepository->countAllFlashcard();
        return $this->calculatePercent(
            $this->flashcardRepository->countAllQuestionsWithOneAnswer(),
            $numberOfAllFlashcards
        );
    }

    public function calculateProgress(): int
    {
        $numberOfAllFlashcards = $this->flashcardRepository->countAllFlashcard();
        return $this->calculatePercent(
            $this->flashcardRepository->countAllQuestionsWithCorrectAnswer(),
            $numberOfAllFlashcards
        );
    }

    private function calculatePercent($currentValue, $allValue): int
    {
        if ($allValue == 0) return 0;
        return $currentValue / $allValue * 100;
    }
}
