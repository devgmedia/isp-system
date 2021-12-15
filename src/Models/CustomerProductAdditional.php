<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProductAdditional extends Pivot
{
    public $incrementing = true;
    protected $table = 'customer_product_additional';

    protected $attributes = [
        'first_month_not_billed' => false,

        'ignore_tax' => false,
    ];

    protected $fillable = [
        // 'id',
        'sid',
        'registration_date',
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

        'dependency',
        
        'first_month_not_billed',
        
        'adjusted_price',
        'special_price',
        
        'adjusted_quantity',
        'quantity',

        'ignore_tax',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'sid' => 'string',
        'registration_date' => 'date:Y-m-d',
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

        'dependency' => 'integer',
        
        'first_month_not_billed' => 'boolean',

        'adjusted_price' => 'boolean',
        'special_price' => 'integer',

        'adjusted_quantity' => 'boolean',
        'quantity' => 'integer',

        'ignore_tax' => 'boolean',
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

    public function dependency()
    {
        return $this->belongsTo(CustomerProductAdditional::class, 'dependency');
    }

    public function required_by()
    {
        return $this->hasMany(CustomerProductAdditional::class, 'dependency');
    }

    public function invoice_scheme_additional()
    {
        return $this->hasOne(ArInvoiceSchemeCustomerProductAdditional::class, 'customer_product_additional_id');
    }

    public function invoice_additionals()
    {
        return $this->hasMany(ArInvoiceCustomerProductAdditional::class, 'customer_product_additional_id');
    }
}
