<?php

namespace Craftsys\MSG91Client\Laravel\Test;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Craftsys\MSG91Client\Laravel\MSGServiceProvider;
use Craftsys\MSG91Client\Laravel\Facade;

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
