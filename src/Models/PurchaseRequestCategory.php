<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestCategory extends Model
{
    protected $table = 'purchase_request_category';

    protected $fillable = [
        // 'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
