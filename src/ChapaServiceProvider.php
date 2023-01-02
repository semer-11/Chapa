<?php

namespace Chapa\Chapa;

use Illuminate\Support\ServiceProvider;

class ChapaServiceProvider extends ServiceProvider
{


    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . './routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . './migrations');
        $this->loadViewsFrom(__DIR__ . './views', 'chapa');




        $this->publishes([
            __DIR__ . './views' => resource_path('views/chapa'), 'views'
        ]);
        $this->publishes([
            __DIR__ . './migrations/' => database_path('migrations')
        ], 'database');
        $this->publishes(
            [
                __DIR__ . './models/' => app_path('Models/Chapa')
            ],
            'model'
        );
        $this->publishes(
            [
                __DIR__ . './controllers/' => app_path('Http/Controllers/Chapa')
            ],
            'controller'
        );
    }


    public function register()
    {
    }
}
