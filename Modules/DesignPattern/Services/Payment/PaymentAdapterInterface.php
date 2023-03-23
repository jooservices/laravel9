<?php

namespace Modules\DesignPattern\Services\Payment;

interface PaymentAdapterInterface
{
    public function processPayment($amount): bool;
}
