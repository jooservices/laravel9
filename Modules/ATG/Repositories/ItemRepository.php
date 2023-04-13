<?php

namespace Modules\ATG\Repositories;

use Modules\ATG\Models\Item;
use Modules\Core\Repositories\Traits\HasIndex;

class ItemRepository
{
    use HasIndex;

    public function __construct(public Item $model)
    {
    }
}
