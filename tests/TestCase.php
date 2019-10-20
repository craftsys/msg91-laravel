<?php

namespace Craftsys\Tests\Msg91;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Craftsys\Msg91\Msg91LaravelServiceProvider as ServiceProvider;
use Craftsys\Msg91\Facade\Msg91 as Facade;

abstract class TestCase extends BaseTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Msg91' => Facade::class
        ];
    }
}
