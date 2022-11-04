<?php

namespace Flashcard\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Marssilen\Flashcard\Models\Flashcard;
use Tests\TestCase;

class ListCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * show table with stats command.
     *
     * @return void
     */
    public function testShowListOfFlashcardInATable()
    {
       Flashcard::factory()->create($this->getTestSample());

        $this->artisan('flashcard:list')
            ->expectsTable([
                'Id',
                'Question',
                'Answer'
            ], [
                [1, 'test', 'test']
            ]);
    }

    private function getTestSample(): array
    {
        $question = 'test';
        $answer = 'test';

        return compact('question', 'answer');
    }
}
