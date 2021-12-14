<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItemPcsUnit extends Model
{
    protected $table = 'purchase_request_item_pcs_unit';

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
