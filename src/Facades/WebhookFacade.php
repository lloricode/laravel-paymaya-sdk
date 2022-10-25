<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Facades;

use Illuminate\Support\Facades\Facade;
use Lloricode\Paymaya\Client\WebhookClient;

/**
 * @mixin \Lloricode\Paymaya\Client\WebhookClient
 */
class WebhookFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WebhookClient::class;
    }
}
