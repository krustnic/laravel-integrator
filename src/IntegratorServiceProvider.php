<?php

namespace Krustnic\Integrator;

use Illuminate\Support\ServiceProvider;

class IntegratorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'integrator');

        $this->app->bind('Integrator', function ($app) {
            return new Integrator();
        });
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes/routes.php';
        }

        $this->loadViewsFrom(__DIR__.'/views', 'integrator');

        $this->publishes([
            __DIR__.'/config/config.php' => config_path('integrator.php')
        ], 'config');

        $this->publishes([
            __DIR__.'/migrations/' => base_path('/database/migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/integrator'),
        ]);

    }

    public function provides()
    {
        return [
            'Integrator'
        ];
    }

}