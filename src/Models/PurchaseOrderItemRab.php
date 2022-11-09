<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItemRab extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'purchase_order_item_rab';

    protected $fillable = [
        // 'id',
        'purchase_order_id',
        'rab_item_id',
        'brand_id',
        'brand_product_id',
        'name',
        'supplier_id',
        'quantity',
        'unit_id',
        'status_ready',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    public function purchase_order()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\RabUnit');
    }
}
