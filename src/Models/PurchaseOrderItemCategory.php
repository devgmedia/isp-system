<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemCategory extends Model
{
    protected $table = 'purchase_order_item_category';

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
    
    public function purchase_order()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }
}
