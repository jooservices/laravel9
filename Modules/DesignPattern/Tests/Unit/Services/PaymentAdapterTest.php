<?php

namespace Modules\DesignPattern\Tests\Unit\Services;

use Modules\DesignPattern\Services\PaymentAdapter;
use Tests\TestCase;

class PaymentAdapterTest extends TestCase
{
    public function testProcessPayment()
    {
        $this->assertTrue(
            app(PaymentAdapter::class)->processPayment(100)
        );
    }
}
