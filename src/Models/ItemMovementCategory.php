<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMovementCategory extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'item_movement_category';

    protected $fillable = [
        // 'id',
 
        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
