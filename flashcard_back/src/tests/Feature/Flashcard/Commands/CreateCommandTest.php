<?php

namespace Flashcard\Commands;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateCommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * show table with stats command.
     *
     * @return void
     */
    public function testCreateCommand()
    {
        $this->artisan('flashcard:create')
            ->expectsQuestion('Please enter the question', 'test')
            ->expectsQuestion('Please enter the answer', 'test')
            ->expectsOutput('New flashcard created');
    }
}
