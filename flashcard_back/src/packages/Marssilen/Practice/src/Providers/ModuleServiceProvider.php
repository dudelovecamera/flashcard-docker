<?php

namespace Marssilen\Practice\Providers;

use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Marssilen\Practice\Models\Answer::class
    ];
}
