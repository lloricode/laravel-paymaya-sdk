<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Tests;

use Lloricode\LaravelPaymaya\LaravelPaymayaServiceProvider;
use Lloricode\Paymaya\Request\Webhook\Webhook;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        config(
            [
                'paymaya-sdk.keys' => [
                    'public' => 'public-xxx',
                    'secret' => 'secret-xxx',
                ],
            ]
        );
    }

    protected static function sampleWebhookData(array $override = []): array
    {
        return $override + [
            'id' => 'test-generated-id',
            'name' => Webhook::CHECKOUT_SUCCESS,
            'callbackUrl' => 'https://web.test/test/success',
            'createdAt' => 'Sun Jan 05 2020 02:30:57 GMT+0000',
            'updatedAt' => 'Sun Jan 05 2020 02:30:57 GMT+0000',
        ];
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPaymayaServiceProvider::class,
        ];
    }
}
