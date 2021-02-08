<?php

namespace Lloricode\LaravelPaymaya;

use Lloricode\Paymaya\PaymayaClient;

class CheckoutClient extends \Lloricode\Paymaya\Client\Checkout\CheckoutClient
{
    public function __construct(PaymayaClient $paymayaClient)
    {
        parent::__construct($paymayaClient);
    }
}
