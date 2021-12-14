<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class RabItem extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'rab_item';

    protected $fillable = [

        'name',
        'purchasing_price',
        'marketing_price',
        'margin_price',
        'rab_id',
        'brand_id',
        'brand_product_id',
        'supplier_id',
        'sales_lent',
        'sales_buy',
        'quantity',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'purchasing_price' => 'integer',
        'marketing_price' => 'integer',
        'margin_price' => 'integer',
        'rab_id' => 'integer',
        'brand_id' => 'integer',
        'brand_product_id' => 'integer',
        'supplier_id' => 'integer',
        'sales_lent' => 'boolean',
        'sales_buy' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item_brand()
    {
        return $this->belongsTo(ItemBrand::class, 'brand_id', 'id');
    }

    public function item_brand_product()
    {
        return $this->belongsTo(ItemBrandProduct::class, 'brand_product_id', 'id');
    }

    public function item_unit()
    {
        return $this->belongsTo(RabUnit::class, 'unit_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
