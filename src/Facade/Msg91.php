<?php

namespace Craftsys\Msg91\Facade;

use Craftsys\Msg91\Client;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for Craftsys\Msg91\Client
 *
 * @method static \Craftsys\Msg91\Services\OTPService otp(mixed $otp = null)
 * @method static \Craftsys\Msg91\Services\SMSService sms(mixed $otp = null)
 */
class Msg91 extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}
