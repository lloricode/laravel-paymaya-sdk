<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya;

use Lloricode\LaravelPaymaya\Facades\CheckoutFacade;
use Lloricode\LaravelPaymaya\Facades\ClientFacade;
use Lloricode\LaravelPaymaya\Facades\CustomizationFacade;
use Lloricode\LaravelPaymaya\Facades\WebhookFacade;
use Lloricode\Paymaya\Client\Checkout\CheckoutClient;
use Lloricode\Paymaya\Client\Checkout\CustomizationClient;
use Lloricode\Paymaya\Client\WebhookClient;
use Lloricode\Paymaya\PaymayaClient;

class LaravelPaymaya
{
    public static function client(): PaymayaClient
    {
        /** @phpstan-ignore return.type */
        return ClientFacade::getFacadeRoot();
    }

    public static function checkout(): CheckoutClient
    {
        /** @phpstan-ignore return.type */
        return CheckoutFacade::getFacadeRoot();
    }

    public static function webhook(): WebhookClient
    {
        /** @phpstan-ignore return.type */
        return WebhookFacade::getFacadeRoot();
    }

    public static function customization(): CustomizationClient
    {
        /** @phpstan-ignore return.type */
        return CustomizationFacade::getFacadeRoot();
    }
}
