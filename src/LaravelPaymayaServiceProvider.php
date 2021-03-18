<?php

namespace Lloricode\LaravelPaymaya;

use Lloricode\LaravelPaymaya\Commands\Customization\DeleteCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Customization\RegisterCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Customization\RetrieveCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Webhook\Checkout\RegisterWebHookCommand;
use Lloricode\LaravelPaymaya\Commands\Webhook\Checkout\RetrieveWebhookCommand;
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
                    RegisterCustomizationCommand::class,
                    RetrieveCustomizationCommand::class,
                    DeleteCustomizationCommand::class,
                ]
            );
    }

    /**
     * @return void
     */
    public function packageRegistered()
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
