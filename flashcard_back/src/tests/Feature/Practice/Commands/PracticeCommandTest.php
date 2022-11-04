<?php

namespace Practice\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Marssilen\Flashcard\Models\Flashcard;
use Tests\TestCase;

class PracticeCommandTest  extends TestCase
{
    use DatabaseTransactions;

    public function testPracticeCommand(){
        Flashcard::factory()->create($this->getTestSample());
        $this->artisan('flashcard:practice')
            ->expectsQuestion('Select one of the questions or enter "exit"', '2')
            ->expectsQuestion('Please enter the answer', 'falseAnswer')
            ->expectsOutput('incorrect')
            ->expectsQuestion('Select one of the questions or enter "exit"', '2')
            ->expectsQuestion('Please enter the answer', 'test')
            ->expectsOutput('correct')
            ->expectsQuestion('Select one of the questions or enter "exit"', 'exit')
            ->assertExitCode(0);
    }

    private function getTestSample(): array
    {
        $question = 'test';
        $answer = 'test';

        return compact('question', 'answer');
    }
}
