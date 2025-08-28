<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Webhook;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Webhook\WebhookDto;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:webhook:create', description: 'Create webhook')]
class CreateWebHookCommand extends Command
{
    public function handle(): int
    {
        try {
            $webhookDtos = PaymayaFacade::webhooks();
        } catch (\Saloon\Exceptions\Request\RequestException $e) {
            if ($e->getStatus() === 404) {
                $webhookDtos = [];
            } else {
                throw $e;
            }
        }

        foreach ($webhookDtos as $webhookDto) {

            /** @var string $id */
            $id = $webhookDto->id;

            PaymayaFacade::deleteWebhook($id);
        }

        foreach (config()->array('paymaya-sdk.webhooks') as $name => $url) {
            /** @var string $name */
            /** @var string $url */
            PaymayaFacade::createWebhook(
                new WebhookDto(
                    name: $name,
                    callbackUrl: url($url),
                )
            );

        }

        $this->info('Done registering webhooks');

        return self::SUCCESS;
    }
}
