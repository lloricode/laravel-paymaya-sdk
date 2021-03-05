<?php

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Request\Checkout\Customization\Customization;

class RegisterCustomizationCommand extends Command
{
    public $signature = 'paymaya-sdk:customization:register';

    public $description = 'Register customization';

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            PaymayaFacade::customization()
                ->register(new Customization(config('paymaya-sdk.checkout.customization')));

            $this->info('Done registering customization');
        } catch (ClientException $exception) {
            $response = (array)json_decode((string)$exception->getResponse()->getBody(), true);

            if (in_array($response['message'] ?: null, ['Missing/invalid parameters.'])) {
                $this->error('Missing/invalid parameters.');
                $this->comment(json_encode($response['parameters'] ?? [], JSON_PRETTY_PRINT));
            }

            return 1;
        }
    }
}
