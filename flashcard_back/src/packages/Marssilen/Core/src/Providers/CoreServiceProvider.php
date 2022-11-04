<?php

namespace Marssilen\Core\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Marssilen\Core\Exceptions\Handler;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->publishes([
            dirname(__DIR__).'/Config/concord.php' => config_path('concord.php'),
        ]);

        $this->app->bind(ExceptionHandler::class, Handler::class);
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
                \Marssilen\Core\Console\Commands\InteractiveCommand::class,
            ]);
        }
    }
}
