<?php

namespace Modules\Core\Http\Controllers\Traits;

trait HasIndexRespond
{
    protected function _respondIndex(LengthAwarePaginator $items, $itemsResource)
    {
        return $this->respondOk(
            [
                'items' => $itemsResource,
                'total' => $items->total(),
                'perPage' => $items->perPage(),
                'count' => $items->count(),
            ]
        );
    }
}
