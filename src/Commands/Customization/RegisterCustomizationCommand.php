<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Request\Checkout\Customization\Customization;

class RegisterCustomizationCommand extends Command
{
    public $signature = 'paymaya-sdk:customization:register';

    public $description = 'Register customization';

    /** @throws \GuzzleHttp\Exception\GuzzleException*/
    public function handle(): int
    {
        try {
            PaymayaFacade::customization()
                /** @phpstan-ignore argument.type */
                ->register(new Customization(...config()->array('paymaya-sdk.checkout.customization')));

            $this->info('Done registering customization');
        } catch (ClientException $exception) {
            $response = (array) json_decode((string) $exception->getResponse()->getBody(), true);

            if (($response['message'] ?? null) === 'Missing/invalid parameters.') {
                $this->error('Missing/invalid parameters.');
                /** @phpstan-ignore-next-line  */
                $this->comment(json_encode($response['parameters'] ?? [], JSON_PRETTY_PRINT));
            }

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
