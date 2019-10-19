<?php

namespace Craftsys\MSG91Client\Laravel;

use Craftsys\MSG91Client\Client;
use Illuminate\Support\ServiceProvider;

class MSGServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind MSG91 Client in Service Container.
        $this->app->singleton(Client::class, function ($app) {
            $config  = $app['config'];
            return new Client($config->get('services.msg91'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class];
    }
}
