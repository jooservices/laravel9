<?php

namespace Modules\ATG\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ATG\Http\Requests\CreateOrderRequest;
use Modules\ATG\Models\Item;
use Modules\ATG\Services\OrderService;
use Modules\ATG\Transformers\OrderResource;
use Modules\Core\Http\Controllers\ApiController;

class OrderController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request, OrderService $service)
    {
        $service->addItems(Item::whereIn('uuid', $request->items)->get());

        return $this->respondCreated(OrderResource::make($service->createOrder()));
    }

}
