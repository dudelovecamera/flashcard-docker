<?php

namespace Practice\Commands;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetCommandTest extends TestCase
{
    use RefreshDatabase;
    
    public function testResetCallCommand(){
        $this->artisan('flashcard:reset')
            ->expectsConfirmation('Do you want to reset all practice progress?', 'yes')
            ->assertExitCode(0);
    }
}
