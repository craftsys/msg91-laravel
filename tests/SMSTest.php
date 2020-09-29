<?php

namespace Craftsys\Tests\Msg91;

use Craftsys\Msg91\Client;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Middleware;
use Craftsys\Msg91\Support\Response as CraftsysResponse;

class SMSTest extends TestCase
{
    protected $container = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = [];
    }

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

    public function test_send_otp()
    {
        /** @var \Craftsys\Msg91\Client $client */
        $client = app(Client::class);
        $response = $client
            ->setHttpClient($this->createMockHttpClient())
            ->sms()
            ->flow('flow_id')
            ->to(91999999999)
            ->variable('day', 'this')
            ->send();

        $this->assertInstanceOf(CraftsysResponse::class, $response);

        // make sure there was exacly on request
        $this->assertCount(1, $this->container);
    }

    protected function createMockHttpClient(
        $status_code = 200,
        $body = [
            "type" => "success", "message" => "Send successfully"
        ]
    ): HttpClient {
        $history = Middleware::history($this->container);
        $mock = new MockHandler([
            new Response($status_code, [], json_encode($body)),
        ]);

        $handler = HandlerStack::create($mock);
        $handler->push($history);

        $client = new HttpClient(['handler' => $handler]);
        return $client;
    }
}
