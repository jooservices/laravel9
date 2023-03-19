<?php

namespace Modules\Jitera\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class create_follows_table extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Jitera\Database\factories\CreateFollowsTableFactory::new();
    }
}
