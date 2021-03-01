<?php

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Request\Checkout\Customization\Customization;

class RegisterCustomizationCommand extends Command
{
    public $signature = 'paymaya-sdk:customization:register';

    public $description = 'Register customization';

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function handle(): void
    {
        PaymayaFacade::customization()
            ->register(new Customization(config('paymaya-sdk.checkout.customization')));

        $this->info('Done Registering customization');
    }
}
