<?php

namespace Modules\ATG\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ATG\Database\factories\ItemFactory;
use Modules\Core\Models\Traits\HasUuid;

class Item extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'name',
        'model',
        'manufacturer',
    ];

    protected static function newFactory()
    {
        return ItemFactory::new();
    }
}
