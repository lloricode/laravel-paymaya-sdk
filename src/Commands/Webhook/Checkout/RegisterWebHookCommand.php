<?php

namespace Lloricode\LaravelPaymaya\Commands\Webhook\Checkout;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Request\Webhook\Webhook;

class RegisterWebHookCommand extends Command
{
    public $signature = 'paymaya-sdk:webhook:register';

    public $description = 'Register webhook';

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function handle(): void
    {
        PaymayaFacade::webhook()->deleteAll();

        foreach (config('paymaya-sdk.webhooks') as $name => $url) {
            PaymayaFacade::webhook()
                ->register(
                    (new Webhook())
                        ->setName($name)
                        ->setCallbackUrl(url($url))
                );
        }

        $this->info('Done registering webhooks');
    }
}
