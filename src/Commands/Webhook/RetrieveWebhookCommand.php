<?php

namespace Lloricode\LaravelPaymaya\Commands\Webhook;

use Illuminate\Console\Command;
use Lloricode\Paymaya\Client\Checkout\WebhookClient;
use Lloricode\Paymaya\PaymayaClient;

class RetrieveWebhookCommand extends Command
{
    public $signature = 'paymaya-sdk:webhook:retrieve';

    public $description = 'Retrieve registered webhooks';

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
        $webHooks = $this->retrieveWebhooks();

        $this->table(['id', 'name', 'callbackUrl', 'createdAt', 'updatedAt'], $webHooks);
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function retrieveWebhooks(): array
    {
        $return = [];

        foreach (
            (new WebhookClient($this->paymayaClient))
                ->retrieve() as $webhookResponse
        ) {
            $return[] = [
                $webhookResponse->getId(),
                $webhookResponse->getName(),
                $webhookResponse->getCallbackUrl(),
                $webhookResponse->getCreatedAt(),
                $webhookResponse->getUpdatedAt(),
            ];
        }

        return $return;
    }
}
