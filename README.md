# Laravel service provider for Msg91


<p>
<a href="https://packagist.org/packages/craftsys/msg91-laravel"><img src="https://img.shields.io/packagist/dt/craftsys/msg91-laravel" alt="Total Downloads" /></a>
<a href="https://packagist.org/packages/craftsys/msg91-laravel"><img src="https://img.shields.io/packagist/v/craftsys/msg91-laravel?label=version" alt="Latest Stable Version" /></a>
<a href="https://packagist.org/packages/craftsys/msg91-laravel"><img src="https://img.shields.io/packagist/l/craftsys/msg91-laravel" alt="License" /></a>
<a href="https://github.com/craftsys/msg91-laravel/actions/workflows/test.yml"><img src="https://github.com/craftsys/msg91-laravel/actions/workflows/test.yml/badge.svg" alt="Status" /></a>
</p>



This is a **[laravel](https://laravel.com) service provider** for [Msg91 APIs](https://docs.msg91.com/collection/msg91-api-integration/5/pages/139). It wraps the [msg91-php][client] client and provides the same functionality for Laravel applications by exposing a Service Provider and Facade.


## Table of Contents

-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Usage](#usage)
-   [Examples](#examples)
    -   [Managing OTPs](#managing-otps)
        -   [Send OTP](#send-otp)
        -   [Verify OTP](#verify-otp)
        -   [Resend OTP](#resend-otp)
    -   [Sending SMS](#sending-sms)
        - [Bulk SMS](#bulk-sms)
        - [Message Variables](#message-variables)
    -   [Handling Responses](#handling-responses)
-   [Related](#related)
-   [Acknowledgements](#acknowledgements)

## Installation

The packages is available on [Packagist](https://packagist.org/packages/craftsys/msg91-laravel) and can be installed via [Composer](https://getcomposer.org/) by executing following command in shell.

```bash
composer require craftsys/msg91-laravel
```

**prerequisite**

-   php^7.1
-   laravel^5|^6|^7|^8|^9|^10

The package is tested for 5.8+,^6.0,^7.0,^8.0,^9.0,^10.0 only. If you find any bugs for laravel (5.0< >5.8), please file an issue.

### Laravel 5.5+

If you're using Laravel 5.5 or above, the package will automatically register the `Craftsys\Msg91\Msg91LaravelServiceProvider` provider and aliases `Craftsys\Msg91\Facade\Msg91` facade to `Msg91`.

### Laravel 5.4 and below

Add `Craftsys\Msg91\Msg91LaravelServiceProvider` to the `providers` array in your `config/app.php`:

```php
'providers' => [
     // Other service providers...
     Craftsys\Msg91\Msg91LaravelServiceProvider::class,
],
```

If you want to use the facade interface, you can `use` the facade class when needed:

```php
use Craftsys\Msg91\Facade\Msg91;
```

Or add an alias in your `config/app.php`

```php
'aliases' => [
    // other aliases here
    'Msg91' => Craftsys\Msg91\Facade\Msg91::class,
],
```

To verify that everything is working as expected, excecute the following php code somewhere in your application, either
in an example route or in `php artisan tinker` if you are in Laravel.

```php
// this should print the `\Craftsys\Msg91\OTP\OTPService` of some default configuration values
echo Msg91::otp()::class
```

If there is an issue, please check the steps again or open an issue for support.

## Configuration

As the [msg91-php][client] offers configuration that are similar to Laravel's configuration, this package simply ports the Laravel's configuration to the msg91-php client.

The package can be configured by providing a `msg91` key inside your `config/services.php` configuration file.

```php
<?php

return [
  // along with other services
  "msg91" => [
    'key' => env("Msg91_KEY"),
  ],
];
```

and update the `.env` file to get the desired values e.g. `Msg91_KEY`.

Please visit [msg91-php configuration][client-configuration] for a detailed description about the available options and their default values.

## Usage

Once you have [Configured](#configuration) the Laravel/Lumen application to use the service provider and have aliased the facade to `Msg91`, you will have a [msg91-php][client] client (Craftsys\Msg91\Client) instance.

```php
// send otp
Msg91::otp()->to(919999999999)->send();

// resend otp
Msg91::otp()->to(919999999999)->viaVoice()->resend();

// verify otp
Msg91::otp(678612)->to(919999999999)->verify();

// send sms
Msg91::sms()->to(919999999999)->flow('<flow_id>')->send();

// in bulk
Msg91::sms()->to([919999999999, 918899898990])->flow('<flow_id>')->send();

// with variables in your flow template
Msg91::sms()->to([919999999999, 918899898990])->flow('<flow_id>')->variable('variable_name', 'value')->send();

// with variables per recipient
Msg91::sms()->recipients([
  ['mobiles' => 919999999999, 'name' => 'Sudhir M'],
  ['mobiles' => 918899898990, 'name' => 'Craft Sys']
])
  ->flow('<flow_id>')
  ->send();
```

Follow along with [examples](#examples) to learn more

## Examples

### Managing OTPs

OTP services like sending, verifying, and resending etc, can be accessed via `otp` method on the client instance e.g. `Msg91::otp()`.

> For a detailed usage, please visit [msg91-php's documentation][client-managing-otps] on managing OTPs.

#### Send OTP

```php
Msg91::otp()
    ->to(912343434312) // phone number with country code
    ->template('your_template_id') // set the otp template
    ->send(); // send the otp
```

### Verify OTP

```php
Msg91::otp(1234) // OTP to be verified
    ->to(912343434312) // phone number with country code
    ->verify(); // Verify
```

### Resend OTP

```php
Msg91::otp()
    ->to(912343434312) // set the mobile with country code
    ->viaVoice() // set the otp sending method (can be "viaText" as well)
    ->resend(); // resend otp
```

## Sending SMS

```php
Msg91::sms()
    ->to(912343434312) // set the mobile with country code
    ->flow("your_flow_id_here") // set the flow id
    ->send(); // send
```

### Bulk SMS

```php
Msg91::sms()
    ->to([912343434312, 919898889892]) // set the mobiles with country code
    ->flow("your_flow_id_here") // set the flow id
    ->send(); // send
```

### Message Variables

```php
// send in bulk with variables    
Msg91::sms()
    ->to([912343434312, 919898889892]) // set the mobiles with country code
    ->flow("your_flow_id_here") // set the flow id
    ->variable('date', "Sunday") // the the value for variable "date" in your flow message template
    ->send(); // send
    
// send in bulk with variables per recipient
Msg91::sms()
    ->to([912343434312, 919898889892]) // set the mobiles with country code
    ->flow("your_flow_id_here") // set the flow id
    ->recipients([
      ['mobiles' => 919999223345, 'name' => 'Sudhir M'],
      ['mobiles' => 912929223345, 'name' => 'Craft Sys']
    ])
    // (optionally) set a "date" variable for all the recipients
    ->variable('date', "Sunday")
    ->send(); // send
```

> For a detailed usage and options, please visit [msg91-php's documentation][client-sending-sms] on sending SMSs. 

## Handling Responses

All the services will return `\Craftsys\Msg91\Support\Response` instance for all successfully responses or will throw exceptions if request validation failed (`\Craftsys\Msg91\Exceptions\ValidationException`)or there was an error in the response (`\Craftsys\Msg91\Exceptions\ResponseErrorException`).

```php
try {
    $response = $client->otp()->to(919999999999)->send();
} catch (\Craftsys\Msg91\Exceptions\ValidationException $e) {
    // issue with the request e.g. token not provided
} catch (\Craftsys\Msg91\Exceptions\ResponseErrorException $e) {
    // error thrown by msg91 apis or by http client
} catch (\Exception $e) {
    // something else went wrong
    // plese report if this happens :)
}
```

> For all the examples and options, please consult [msg91-php examples section][client-examples]

[client]: https://github.com/craftsys/msg91-php
[client-configuration]: https://github.com/craftsys/msg91-php#configuration
[client-examples]: https://github.com/craftsys/msg91-php#examples
[client-managing-otps]: https://github.com/craftsys/msg91-php#managing-otps
[client-sending-sms]: https://github.com/craftsys/msg91-php#sending-sms


# Related

- [Msg91 Laravel Notification Channel](https://github.com/craftsys/msg91-laravel-notification-channel)
- [Msg91 Php Client](https://github.com/craftsys/msg91-php)
- [Msg91 Api Docs](https://docs.msg91.com/collection/msg91-api-integration/5/pages/139)

# Acknowledgements

We are grateful to the authors of existing related projects for their ideas and collaboration:

- [Laravel Nexmo](https://github.com/Nexmo/nexmo-laravel)
