<?php

namespace Marssilen\Practice\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('marssilen.practice.answer.after', 'Marssilen\Practice\Listeners\Practice@createAnswer');
    }
}
