<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook\Checkout;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Webhook\WebhookDto;
use Lloricode\Paymaya\Requests\Webhook\DeleteWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\RegisterWebhookRequest;
use Lloricode\Paymaya\Requests\Webhook\RetrieveWebhookRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:webhook:register', description: 'Register webhook')]
class RegisterWebHookCommand extends Command
{
    public function handle(): int
    {

        $response = PaymayaFacade::connector()->send(new RetrieveWebhookRequest);

        if ($response->failed()) {

            report($response->toException());

            $this->error('Failed registering webhooks: '.$response->array('error') ?? 'unknown');

            return self::FAILURE;
        }

        try {
            /** @var array<string, WebhookDto> $webhooks */
            $webhooks = $response->dto();
        } catch (\Exception $e) {
            $webhooks = [];
        }

        foreach ($webhooks as $webhook) {

            if ($webhook->id === null) {
                continue;
            }

            PaymayaFacade::connector()->send(new DeleteWebhookRequest($webhook->id));
        }

        foreach (config()->array('paymaya-sdk.webhooks') as $name => $url) {

            /** @var string $url */
            PaymayaFacade::connector()->send(new RegisterWebhookRequest(
                new WebhookDto(
                    name: $name,
                    callbackUrl: url($url),
                )
            ));
        }

        $this->info('Done registering webhooks');

        return self::SUCCESS;
    }
}
