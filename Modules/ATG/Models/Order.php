<?php

namespace Modules\ATG\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ATG\Database\factories\OrderFactory;
use Modules\Core\Models\Traits\HasUuid;

class Order extends Model
{
    use HasFactory;
    use HasUuid;

    protected $fillable = [
        'total'
    ];

    protected $casts = [
        'total' => 'decimal:6',
        'status' => 'string',
    ];

    protected static function newFactory()
    {
        return OrderFactory::new();
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
