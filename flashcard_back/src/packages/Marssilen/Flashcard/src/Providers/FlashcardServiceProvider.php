<?php

namespace Marssilen\Flashcard\Providers;

use Illuminate\Support\ServiceProvider;

class FlashcardServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadFactoriesFrom(__DIR__ . '/../Database/Factories');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCommands();
    }

    /**
     * Register the console commands of this package.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Marssilen\Flashcard\Console\Commands\CreateCommand::class,
                \Marssilen\Flashcard\Console\Commands\ListCommand::class
            ]);
        }
    }

}
