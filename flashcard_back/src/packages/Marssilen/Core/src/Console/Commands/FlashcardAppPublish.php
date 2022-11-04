<?php

namespace Marssilen\Core\Console\Commands;

use Illuminate\Console\Command;

class FlashcardAppPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcardApp:publish { --force : Overwrite any existing files }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the available assets';

    /**
     * List of providers.
     *
     * @var array
     */
    protected $providers = [

        [
            'name'     => 'Core',
            'provider' => \Marssilen\Core\Providers\CoreServiceProvider::class,
        ],
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->publishAllPackages();
    }

    /**
     * Publish all packages.
     *
     * @return void
     */
    public function publishAllPackages(): void
    {
        collect($this->providers)->each(function ($provider) {
            $this->publishPackage($provider);
        });
    }

    /**
     * Publish package.
     *
     * @param  array  $provider
     * @return void
     */
    public function publishPackage(array $provider): void
    {
        $this->line('');
        $this->line('-----------------------------------------');
        $this->info('Publishing ' . $provider['name']);
        $this->line('-----------------------------------------');

        $this->call('vendor:publish', [
            '--provider' => $provider['provider'],
            '--force'    => $this->option('force'),
        ]);
    }
}
