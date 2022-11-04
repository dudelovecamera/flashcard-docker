<?php

namespace Marssilen\Flashcard\Repositories;

use Marssilen\Core\Eloquent\Repository;

class FlashcardRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model(): string
    {
        return 'Marssilen\Flashcard\Contracts\Flashcard';
    }

    /**
     * Count all flashcards.
     *
     * @return int
     */
    public function countAllFlashcard(): int
    {
        return $this->getModel()
            ->get()
            ->count();
    }

    /**
     * Count all questions with at least one answer.
     *
     * @return int
     */
    public function countAllQuestionsWithOneAnswer(): int
    {
        return $this->getModel()
            ->join('answers', 'answers.flashcard_id', '=', 'flashcards.id')
            ->get()->groupBy('flashcard_id')
            ->count();
    }

    /**
     * Count all questions with correct answer.
     *
     * @return int
     */
    public function countAllQuestionsWithCorrectAnswer(): int
    {
        return $this->getModel()
            ->join('answers', 'answers.flashcard_id', '=', 'flashcards.id')
            ->where('answers.is_correct', '1')
            ->get()->count();
    }
}
