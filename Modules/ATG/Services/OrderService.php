<?php

namespace Modules\ATG\Services;

use Illuminate\Support\Collection;
use Modules\ATG\Models\Item;
use Modules\ATG\Models\Order;

class OrderService
{
    private Collection $items;

    public function __construct()
    {
        $this->items = collect();
    }

    public function add(Item $item)
    {
        $this->items->add($item);
    }

    public function addItems(Collection $items)
    {
        $this->items = $this->items->merge($items);
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function createOrder()
    {
        $order = Order::create();
        $order->items()->saveMany($this->items);
        $order->update(['total' => $order->items->sum('price')]);

        return $order;
    }
}
