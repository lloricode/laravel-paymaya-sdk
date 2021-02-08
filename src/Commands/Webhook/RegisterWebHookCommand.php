<?php

namespace Lloricode\LaravelPaymaya\Commands\Webhook;

use Illuminate\Console\Command;
use Lloricode\Paymaya\Client\Checkout\WebhookClient;
use Lloricode\Paymaya\PaymayaClient;
use Lloricode\Paymaya\Request\Checkout\WebhookRequest;

class RegisterWebHookCommand extends Command
{
    public $signature = 'paymaya-sdk:webhook:register';

    public $description = 'Register webhook';

    private PaymayaClient $paymayaClient;

    public function __construct(PaymayaClient $paymayaClient)
    {
        parent::__construct();
        $this->paymayaClient = $paymayaClient;
    }

    /**
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     */
    public function handle(): void
    {
        (new WebhookClient($this->paymayaClient))->deleteAll();

        foreach (config('paymaya-sdk.webhooks') as $name => $url) {
            (new WebhookClient($this->paymayaClient))
                ->register(
                    WebhookRequest::new()
                        ->setName($name)
                        ->setCallbackUrl(url($url))
                );
        }

        $this->info('Done Registering webhooks');
    }
}
