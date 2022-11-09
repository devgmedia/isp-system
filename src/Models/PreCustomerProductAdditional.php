<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PreCustomerProductAdditional extends Pivot
{
    public $incrementing = true;

    protected $connection = 'isp_system';

    protected $table = 'pre_customer_product_additional';

    protected $fillable = [
        // 'id',

        'pre_customer_product_id',
        'product_additional_id',

        'media_id',
        'media_vendor_id',

        'created_at',
        'updated_at',

        'sid',

        'additional_name',
        'additional_price',
        'additional_price_usd',
        'additional_price_sgd',
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

        'sid' => 'string',

        'additional_name' => 'string',
        'additional_price' => 'integer',
        'additional_price_usd' => 'integer',
        'additional_price_sgd' => 'integer',
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
