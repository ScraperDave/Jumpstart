<?php namespace GeneaLabs\Jumpstart;

use GeneaLabs\Jumpstart\Commands\Jumpstart;
use Illuminate\Support\ServiceProvider;

class JumpstartServiceProvider extends ServiceProvider
{
    protected $commands = [
        Jumpstart::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'jumpstart');
    }
}
