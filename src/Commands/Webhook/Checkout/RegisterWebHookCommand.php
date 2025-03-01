<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook\Checkout;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\Request\Webhook\Webhook;

class RegisterWebHookCommand extends Command
{
    public $signature = 'paymaya-sdk:webhook:register';

    public $description = 'Register webhook';

    /** @throws \GuzzleHttp\Exception\GuzzleException*/
    public function handle(): void
    {
        PaymayaFacade::webhook()->deleteAll();

        foreach (config()->array('paymaya-sdk.webhooks') as $name => $url) {
            PaymayaFacade::webhook()
                ->register(
                    (new Webhook)
                        ->setName($name)
                        /** @phpstan-ignore-next-line  */
                        ->setCallbackUrl(url($url))
                );
        }

        $this->info('Done registering webhooks');
    }
}
