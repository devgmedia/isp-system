<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemPacksUnit extends Model
{
    protected $table = 'purchase_order_item_packs_unit';

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
