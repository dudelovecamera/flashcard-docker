<?php

namespace Marssilen\Practice\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Marssilen\Practice\DataTransferObjects\FlashcardData;

class FlashcardInputValidator
{

    protected $validator;

    public function __construct(protected $id, protected $availableOptions)
    {
    }

    private function validateInput()
    {
        $rules = [
            'id' => ['required', 'integer', Rule::in($this->availableOptions)]
        ];
        
        return Validator::make(['id' => $this->id], $rules);
    }

    public function validated(): FlashcardData
    {
        return new FlashcardData(...$this->validateInput()->validated());
    }

}
