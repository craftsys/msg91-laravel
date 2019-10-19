<?php

namespace Craftsys\Laravel\MSG91Client;

use Craftsys\MSG91Client\Client;
use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * Facade for Craftsys\MSG91Client\Client
 *
 * @method static \Craftsys\MSG91Client\OTPMessage otp(int|null $otp = null)
 */
class Facade extends BaseFacade
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
