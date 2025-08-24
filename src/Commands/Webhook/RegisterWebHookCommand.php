<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook;

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

        if ($response->status() === 404) {
            //
        } elseif ($response->failed()) {

            $response->throw();

            return self::FAILURE;
        }

        /** @var array<string, WebhookDto> $webhooks */
        $webhooks = $response->status() === 404 ? [] : $response->dto();

        foreach ($webhooks as $webhook) {

            if ($webhook->id === null) {
                continue;
            }

            PaymayaFacade::connector()->send(new DeleteWebhookRequest($webhook->id));
        }

        foreach (config()->array('paymaya-sdk.webhooks') as $name => $url) {

            /** @var string $url */
            $response = PaymayaFacade::connector()->send(new RegisterWebhookRequest(
                new WebhookDto(
                    name: $name,
                    callbackUrl: url($url),
                )
            ));

            $response->throw();
        }

        $this->info('Done registering webhooks');

        return self::SUCCESS;
    }
}
