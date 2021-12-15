<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PreCustomerProductAdditional extends Pivot
{
    public $incrementing = true;
    protected $table = 'pre_customer_product_additional';

    protected $fillable = [
        // 'id',
        'pre_customer_product_id',
        'product_additional_id',
        'media_id',
        'media_vendor_id',

        'created_at',
        'updated_at',
        
        'adjusted_price',
        'special_price',
        
        'adjusted_quantity',
        'quantity',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'pre_customer_product_id' => 'integer',
        'product_additional_id' => 'integer',
        'media_id' => 'integer',
        'media_vendor_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'adjusted_price' => 'boolean',
        'special_price' => 'integer',
        'adjusted_quantity' => 'boolean',
        'quantity' => 'integer',
    ];

    public function pre_customer_product()
    {
        return $this->belongsTo(PreCustomerProduct::class);
    }

    public function product_additional()
    {
        return $this->belongsTo(ProductAdditional::class);
    }

    public function media()
    {
        return $this->belongsTo(InternetMedia::class);
    }

    public function media_vendor()
    {
        return $this->belongsTo(InternetMediaVendor::class);
    }
}
