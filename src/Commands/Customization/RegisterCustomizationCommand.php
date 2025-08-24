<?php

declare(strict_types=1);

namespace Lloricode\LaravelPaymaya\Commands\Customization;

use Illuminate\Console\Command;
use Lloricode\LaravelPaymaya\Facades\PaymayaFacade;
use Lloricode\Paymaya\DataTransferObjects\Checkout\Customization\CustomizationDto;
use Lloricode\Paymaya\Requests\Customization\RegisterCustomizationRequest;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'paymaya-sdk:customization:register', description: 'Register customization')]
class RegisterCustomizationCommand extends Command
{
    public function handle(): int
    {
        $response = PaymayaFacade::connector()->send(new RegisterCustomizationRequest(
            new CustomizationDto(
                ...config()->array('paymaya-sdk.checkout.customization')
                //                logoUrl: config('paymaya-sdk.checkout.customization.logoUrl'),
                //                iconUrl: config('paymaya-sdk.checkout.customization.iconUrl'),
                //                appleTouchIconUrl: config('paymaya-sdk.checkout.customization.appleTouchIconUrl'),
                //                customTitle: config('paymaya-sdk.checkout.customization.customTitle'),
                //                colorScheme: config('paymaya-sdk.checkout.customization.colorScheme'),
                //                redirectTimer: config('paymaya-sdk.checkout.customization.redirectTimer'),
                //                hideReceiptInput: config('paymaya-sdk.checkout.customization.hideReceiptInput'),
                //                skipResultPage: config('paymaya-sdk.checkout.customization.skipResultPage'),
                //                showMerchantName: config('paymaya-sdk.checkout.customization.showMerchantName'),
            )
        ));

        if ($response->successful()) {
            $this->info('Done registering customization');

            return self::SUCCESS;
        }

        $response->throw();

        return self::FAILURE;
    }
}
