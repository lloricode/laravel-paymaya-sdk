<?php

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\Paymaya\Client\Checkout\WebhookClient;

/**
 * @mixin \Lloricode\Paymaya\Client\Checkout\WebhookClient
 */
class WebhookFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WebhookClient::class;
    }
}
