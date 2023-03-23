<?php

namespace Modules\DesignPattern\Services\Payment;

use Illuminate\Support\Facades\Event;
use Modules\DesignPattern\Events\PaymentDispatched;

class Paypal implements PaymentGatewayInterface
{
    public function pay($amount): bool
    {
        Event::dispatch(new PaymentDispatched($amount));

        return true;
    }
}
