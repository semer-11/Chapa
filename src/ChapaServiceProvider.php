<?php

namespace Semernur\Chapa;

use Illuminate\Support\ServiceProvider;

class ChapaServiceProvider extends ServiceProvider
{

    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('chapa.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'chapa');

        $this->app->singleton('chapa', function () {
            return new Chapa;
        });
    }
}
