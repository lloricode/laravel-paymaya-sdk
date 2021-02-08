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

    public function handle()
    {
        foreach (config('paymaya-sdk.webhooks') as $name => $url) {
            WebhookClient::new($this->paymayaClient)
                ->register(
                    WebhookRequest::new()
                        ->setName($name)
                        ->setCallbackUrl($url)
                );
        }

        $this->info('Done Registering webhooks');
    }
}
