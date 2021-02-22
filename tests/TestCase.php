<?php

namespace Lloricode\LaravelPaymaya\Tests;

use Lloricode\LaravelPaymaya\LaravelPaymayaServiceProvider;
use Lloricode\Paymaya\Request\Checkout\Webhook;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected static function sampleWebhookData(array $override = []): array
    {
        return $override + [
                'name' => Webhook::SUCCESS,
                'id' => 'test-generated-id',
                'callbackUrl' => 'https://web.test/test/success',
                'createdAt' => '2020-01-05T02:30:57.000Z',
                'updatedAt' => '2021-02-05T02:30:57.000Z',
            ];
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPaymayaServiceProvider::class,
        ];
    }
}
