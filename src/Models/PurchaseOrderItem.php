<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Models\PurchaseOrderItemSource as PurchaseOrderItemSourceModel;

class PurchaseOrderItem extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'purchase_order_item';

    protected $fillable = [
        // 'id',
        'purchase_order_id',
        'item_brand_name',
        'item_brand_product_name',
        'item_name',
        'item_brand_id',
        'item_brand_product_id', 
        'price',
        'quantity',
        'total',
        'supplier_id',
        'purchase_request_id',
        'purchase_request_number',
        'source_id',
        'note',
        'unit_id',
        'sumber_id',
        'number',
        'customer_name',
        'customer_id',
        'ppn',
        'diskon',
        'packs_unit_id',
        'packs_quantity',
        'created_at',
        'updated_at',
        'category_id'
    ];

    protected $hidden = [];

    // protected $casts = [
    //     'id' => 'integer',
    //     'purchase_order_id' => 'integer',
    //     'item_brand_id' => 'integer',
    //     'item_brand_product_id' => 'integer',
    //     'name' => 'string',
    //     'price' => 'string',
    //     'quantity' => 'string',
    //     'total' => 'string',
    //     'note'  => 'string',
    //     'supplier_' => 'integer',
    //     'purchase_request_id' => 'integer',
    //     'purchase_request_number' => 'integer',
    //     'source_id' => 'integer',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];


    public function purchase_order()
    {
        return $this->belongsTo('App\Models\PurchaseOrder');
    }

    // public function purchase_order_item_source()
    // {
    //     return $this->hasMany(PurchaseOrderItemSourceModel::class, 'source_id');

    // }
    public function source()
    {
        return $this->belongsTo('App\Models\PurchaseOrderItemSource');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\PurchaseOrderItemUnit');
    }
    
}
