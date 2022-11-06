<?php

namespace Marssilen\Practice\Traits;

use Illuminate\Validation\ValidationException;
use Marssilen\Practice\Validators\FlashcardInputValidator;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;

use function collect;


trait FlashcardChoiceQuestion
{

    private array $data;
    private int $progress;
    protected FlashcardInputValidator $validator;

    public function askChoiceQuestion($data, $progress)
    {
        $this->data = $data;
        $this->progress = $progress;

        $this->showChoices();

        $input = $this->ask('Select one of the questions or enter "exit"');
        if ($input == 'exit') {
            return 0;
        }

        $choices = $this->pluckIdFromData($data);
        $this->setValidator($input, $choices);

        return $this->getAnswer();
    }

    private function showChoices(): void
    {
        $this->drawTable($this->data, $this->progress);
    }

    private function drawTable($data, $progress)
    {
        $table = new Table($this->output);

        // Set the table headers.
        $table->setHeaders(['Id', 'Question', 'Status']);
        $data = $this->addFooter($data, $progress);

        // Set the contents of the table.
        $table->setRows($data);

        // Render the table to the output.
        $table->render();
    }

    private function addFooter(&$data, $progress): array
    {
        return array_merge($data, [
            new TableSeparator,
            [
                new TableCell('Progress', ['colspan' => 2]),
                new TableCell("$progress%", ['colspan' => 1])
            ]
        ]);
    }

    private function pluckIdFromData($data): array{
        return collect($data)->pluck('id')->all();
    }

    private function setValidator($input, $choices)
    {
        $this->validator = new FlashcardInputValidator($input, $choices);
    }

    private function getAnswer()
    {
        try {
            return $this->validator->validated()->id;
        } catch (ValidationException  $exception) {
            $this->warn('Please enter a valid Input');
            return $this->askChoiceQuestion($this->data, $this->progress);
        }
    }
}
