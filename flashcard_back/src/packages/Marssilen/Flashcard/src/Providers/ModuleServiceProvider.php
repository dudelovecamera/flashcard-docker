<?php

namespace Marssilen\Flashcard\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Marssilen\Flashcard\Models\Flashcard::class
    ];
}

