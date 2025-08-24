<?php

declare(strict_types=1);

use Lloricode\LaravelPaymaya\Tests\TestCase;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;

uses(TestCase::class)
    ->beforeEach(function () {
        Config::preventStrayRequests();
        MockClient::destroyGlobal();

        config([
            'paymaya-sdk.keys' => [
                'public' => 'fake-publicKey',
                'secret' => 'fake-secretKey',
            ],
        ]);
    })
    ->in(__DIR__);
