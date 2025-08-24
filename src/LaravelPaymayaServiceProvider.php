<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya;

use Lloricode\LaravelPaymaya\Commands\Customization\DeleteCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Customization\RegisterCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Customization\RetrieveCustomizationCommand;
use Lloricode\LaravelPaymaya\Commands\Webhook\RegisterWebHookCommand;
use Lloricode\LaravelPaymaya\Commands\Webhook\RetrieveWebhookCommand;
use Lloricode\Paymaya\Enums\Environment;
use Lloricode\Paymaya\PaymayaConnector;
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

    public function packageRegistered(): void
    {
        $this->app->singleton(
            PaymayaConnector::class,
            fn () => new PaymayaConnector(
                environment: Environment::from(config()->string('paymaya-sdk.mode')),
                secretKey: config()->string('paymaya-sdk.keys.secret'),
                publicKey: config()->string('paymaya-sdk.keys.public'),
            )
        );
    }
}
