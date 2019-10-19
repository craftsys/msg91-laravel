<?php

namespace Craftsys\Laravel\MSG91Client\Test;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Craftsys\Laravel\MSG91Client\MSGServiceProvider;
use Craftsys\Laravel\MSG91Client\Facade;

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
            MSGServiceProvider::class,
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
            'MSG91' => Facade::class
        ];
    }
}
