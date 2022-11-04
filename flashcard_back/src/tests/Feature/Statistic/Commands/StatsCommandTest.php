<?php

namespace Statistic\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StatsCommandTest extends TestCase
{
    use RefreshDatabase;

    /**
     * show table with stats command.
     *
     * @return void
     */
    public function testShowTableStats()
    {

        $this->artisan('flashcard:stats')
            ->expectsTable([
                'The total amount of questions',
                '% of questions that have an answer',
                '% of questions that have a correct answer'
            ], [
                ['0', '0', '0']
            ]);
    }
}
