<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemTypeQualityControl extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'item_type_quality_control';

    protected $fillable = [
        // 'id',

        'name', 
        'item_type_id',  
        'created_at',
        'updated_at', 
    ];

    protected $hidden = [];

    protected $casts = [
        // 'id' => 'integer',

        'name' => 'string',
        'item_type_id' => 'integer',  
        'created_at' => 'datetime',
        'updated_at' => 'datetime', 
    ]; 
}
