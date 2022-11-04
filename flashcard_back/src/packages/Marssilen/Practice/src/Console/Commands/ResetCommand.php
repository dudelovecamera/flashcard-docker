<?php

namespace Marssilen\Practice\Console\Commands;

use Illuminate\Console\Command;
use Marssilen\Practice\Repositories\PracticeRepository;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'flashcard:reset')]
class ResetCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flashcard:reset';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Erase all practice progress and allow a fresh start.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected PracticeRepository $practiceRepository) {
        parent::__construct();
    }

    /**
     * Reset practice process.
     */
    public function handle()
    {
        if ($this->confirm("Do you want to reset all practice progress?", false)) {
            $this->warn('Step: resetting progress...');

            $this->massDestroy();

            $this->info('-----------------------------');
            $this->info('Progress reset!');
        }
    }

    /**
     * Mass delete the products.
     *
     */
    public function massDestroy(): void
    {
        $this->practiceRepository->truncate();
    }
}
