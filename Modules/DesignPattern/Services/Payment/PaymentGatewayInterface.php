<?php

namespace Modules\DesignPattern\Services\Payment;

interface PaymentGatewayInterface
{
    public function pay($amount): bool;
}
