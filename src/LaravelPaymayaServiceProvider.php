<?php

namespace Lloricode\LaravelPaymaya;

use Lloricode\LaravelPaymaya\Commands\LaravelPaymayaCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPaymayaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('paymaya-sdk')
            ->hasConfigFile()
            ->hasCommand(LaravelPaymayaCommand::class);
    }
}
