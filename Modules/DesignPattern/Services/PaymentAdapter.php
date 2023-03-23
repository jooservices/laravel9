<?php

namespace Modules\DesignPattern\Services;

use Modules\DesignPattern\Services\Payment\PaymentAdapterInterface;
use Modules\DesignPattern\Services\Payment\PaymentGatewayInterface;

class PaymentAdapter implements PaymentAdapterInterface
{
    public function __construct(private PaymentGatewayInterface $paymentGateway)
    {
    }
    public function processPayment($amount): bool
    {
        return $this->paymentGateway->pay($amount);
    }

}
