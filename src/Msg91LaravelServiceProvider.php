<?php

namespace Craftsys\Msg91;

use Craftsys\Msg91\Client;
use Illuminate\Support\ServiceProvider;

class Msg91LaravelServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind Msg91 Client in Service Container.
        $this->app->bind(Client::class, function ($app) {
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
