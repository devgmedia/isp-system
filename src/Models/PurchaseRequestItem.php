<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'purchase_request_item';

    protected $fillable = [
        // 'id',
        'purchase_request_id',
        'item_brand_id',
        'item_brand_product_id', 
        'price',
        'quantity',
        'total',
        'supplier-id',
        'created_at',
        'updated_at',
        'item_id',
        'item_name',
        'item_brand_name',
        'item_brand_product_name',
        'unit_id', 
        'source_id',
        'number',
        'customer_name',
        'customer_id',
        'category_id',
        
        'item_type_id',
        'pcs_quantity',
        'pcs_unit_id',
        'packs_quantity',
        'packs_unit_id',
    ];

    protected $hidden = [];

    // protected $casts = [
    //     'id' => 'integer',
    //     'purchase_request_id' => 'integer',
    //     'item_brand_id' => 'integer',
    //     'item_brand_product_id' => 'integer',
    //     // 'name' => 'string',
    //     'price' => 'double',
    //     'quantity' => 'integer',
    //     'total' => 'double',
    //     'supplier_id' => 'integer',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    //     'item_id' => 'integer',
    //     'item_name' => 'string',
    //     'item_brand_name' => 'string',
    //     'item_brand_product_product_name' => 'string',
    // ];

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\PurchaseRequest');
    }

    public function source()
    {
        return $this->belongsTo('App\Models\PurchaseRequestItemSource');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\PurchaseRequestItemUnit');
    }
}
