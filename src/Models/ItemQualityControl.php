<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemQualityControl extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'item_quality_control';

    protected $fillable = [
        // 'id',

        'name',
        'status',
        'item_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        // 'id' => 'integer',

        'name' => 'string',
        'status' => 'boolean',
        'item_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
