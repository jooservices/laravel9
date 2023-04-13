<?php

namespace Modules\ATG\Http\Controllers;

use Modules\ATG\Http\Requests\GetItemsRequest;
use Modules\ATG\Repositories\ItemRepository;
use Modules\ATG\Transformers\ItemResource;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Http\Controllers\Traits\HasIndexRespond;

class ItemController extends ApiController
{
    use HasIndexRespond;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetItemsRequest $request, ItemRepository $itemRepository)
    {
        $items = $itemRepository->index($request);

        return $this->_respondIndex($items, ItemResource::collection($items));
    }
}
