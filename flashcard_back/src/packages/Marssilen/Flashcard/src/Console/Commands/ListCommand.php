<?php

namespace Marssilen\Flashcard\Console\Commands;

use Illuminate\Console\Command;
use Marssilen\Flashcard\Repositories\FlashcardRepository;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'flashcard:list')]
class ListCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flashcard:list';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A table listing all the created flashcard questions with the correct answer.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(protected FlashcardRepository $flashcardRepository,
    ) {
        parent::__construct();
    }

    /**
     * List all flashcards
     * @return void
     */
    public function handle()
    {
        $this->drawTable();
    }

    /**
     * Draw Table
     * @return void
     */
    private function drawTable(){
        $headers = ['Id', 'Question', 'Answer'];

        $data = $this->flashcardRepository->all($headers);

        $this->table($headers, $data);
    }
}
