<?php

namespace Lloricode\LaravelPaymaya\Commands\Webhook;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;

class RetrieveWebhookCommand extends Command
{
    public $signature = 'paymaya-sdk:webhook:retrieve';

    public $description = 'Retrieve registered webhooks';

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

        foreach (PaymayaFacade::webhook()->retrieve() as $webhookResponse) {
            $return[] = [
                $webhookResponse->id,
                $webhookResponse->name,
                $webhookResponse->callbackUrl,
                $webhookResponse->createdAt,
                $webhookResponse->updatedAt,
            ];
        }

        return $return;
    }
}
