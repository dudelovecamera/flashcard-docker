<?php

namespace Marssilen\Practice\Listeners;

use Marssilen\Practice\Repositories\PracticeRepository;

class Practice
{
    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(protected PracticeRepository $practiceRepository)
    {
    }

    /**
     * Create a new resource.
     *
     * @return void
     */
    public function createAnswer($id, $answer, $isCorrect)
    {
        $this->practiceRepository->createAnswer($id, $answer, $isCorrect);
    }

    public function calculateProgress()
    {
        $this->practiceRepository->calculateProgress();
    }
}
