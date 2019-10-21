<?php

namespace Craftsys\Tests\Msg91;

use Craftsys\Msg91\Client;

class ServiceProviderTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('services.msg91.key', 'my_api_key');
    }

    /**
     * Test that we can create the Msg91 client
     * from container binding.
     *
     * @return void
     */
    public function testClientResolutionFromContainer()
    {
        $client = app(Client::class);
        $this->assertInstanceOf(Client::class, $client);
    }
}
