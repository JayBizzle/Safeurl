<?php

namespace Jaybizzle\Safeurl;

use Illuminate\Support\ServiceProvider;

class SafeurlServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes(array(
            __DIR__.'/config/config.php' => base_path('config/safeurl.php'),
        ));

        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'safeurl');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('safeurl', function ($app) {
            return new Safeurl();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
