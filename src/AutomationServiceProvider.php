<?php

namespace Amghrby\Automation;

use Illuminate\Support\ServiceProvider;
use Amghrby\Automation\Providers\ObserverServiceProvider;

class AutomationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerResources();
        $this->app->register(ObserverServiceProvider::class);
    }

    protected function registerResources()
    {
        $this->publishes([
            __DIR__.'/../config/workflows.php' => config_path('workflows.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/workflows.php', 'workflows'
        );
    }
}
