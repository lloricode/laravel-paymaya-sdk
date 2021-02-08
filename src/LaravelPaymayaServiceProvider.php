<?php

namespace Lloricode\LaravelPaymaya;

use Lloricode\LaravelPaymaya\Commands\Webhook\RegisterWebHookCommand;
use Lloricode\LaravelPaymaya\Commands\Webhook\RetrieveWebhookCommand;
use Lloricode\Paymaya\PaymayaClient;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPaymayaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-paymaya-sdk')
            ->hasConfigFile()
            ->hasCommands(
                [
                    RetrieveWebhookCommand::class,
                    RegisterWebHookCommand::class,
                ]
            );
    }

    /**
     * @return void
     */
    public function packageBooted()
    {
        $this->app->singleton(
            PaymayaClient::class,
            fn () => new PaymayaClient(
                config('paymaya-sdk.keys.secret'),
                config('paymaya-sdk.keys.public'),
                config('paymaya-sdk.mode'),
            )
        );
    }
}
