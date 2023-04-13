<?php

namespace Modules\ATG\Tests\Unit\Services;

use Modules\ATG\Models\Item;
use Modules\ATG\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    public function testGet()
    {
        $service = app(OrderService::class);
        $item = Item::factory()->create();

        $service->add($item);
        $order = $service->createOrder();

        $this->assertEquals($item->price, $order->total);
    }
}
