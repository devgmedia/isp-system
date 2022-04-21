<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProductAdditional extends Pivot
{
    public $incrementing = true;
    protected $connection = 'isp_system';
    protected $table = 'customer_product_additional';

    protected $attributes = [
        'ignore_tax' => false,
    ];

    protected $fillable = [
        // 'id',
        'sid',

        'customer_product_id',
        'product_additional_id',

        'media_id',
        'media_vendor_id',

        'created_at',
        'updated_at',

        'service_end_date',
        'service_start_date',
        'billing_start_date',
        'billing_end_date',

        'service_date',
        'billing_date',
        
        'adjusted_price',
        'special_price',
        
        'adjusted_quantity',
        'quantity',

        'ignore_tax',

        'ar_invoice_item_category_id',
        'additional_name',
        'additional_price',
        'additional_price_usd',
        'additional_price_sgd',

        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'sid' => 'string',

        'customer_product_id' => 'integer',
        'product_additional_id' => 'integer',
        
        'media_id' => 'integer',
        'media_vendor_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'service_end_date' => 'date:Y-m-d',
        'service_start_date' => 'date:Y-m-d',
        'billing_start_date' => 'date:Y-m-d',
        'billing_end_date' => 'date:Y-m-d',

        'service_date' => 'date:Y-m-d',
        'billing_date' => 'date:Y-m-d',

        'adjusted_price' => 'boolean',
        'special_price' => 'integer',

        'adjusted_quantity' => 'boolean',
        'quantity' => 'integer',

        'ignore_tax' => 'boolean',

        'ar_invoice_item_category_id' => 'integer',
        'additional_name' => 'string',
        'additional_price' => 'integer',
        'additional_price_usd' => 'integer',
        'additional_price_sgd' => 'integer',
        
        'uuid' => 'string',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
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

    public function invoice_scheme_additional()
    {
        return $this->hasOne(ArInvoiceSchemeCustomerProductAdditional::class, 'customer_product_additional_id');
    }

    public function invoice_additionals()
    {
        return $this->hasMany(ArInvoiceCustomerProductAdditional::class, 'customer_product_additional_id');
    }

    public function ar_invoice_item_category()
    {
        return $this->belongsTo(ArInvoiceItemCategory::class);
    }
}
