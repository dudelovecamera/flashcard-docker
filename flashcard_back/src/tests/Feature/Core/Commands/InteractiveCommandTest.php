<?php

namespace Core\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InteractiveCommandTest extends TestCase
{
    use RefreshDatabase;
    /**
     * show table with stats command.
     *
     * @return void
     */
    public function testInteractiveListCommand()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Which command would you like to run?', 'exit')
            ->assertExitCode(0);
    }

    public function testInteractiveCallCommand(){
        $this->artisan('flashcard:reset')
            ->expectsConfirmation('Do you want to reset all practice progress?', 'no');
    }
}
