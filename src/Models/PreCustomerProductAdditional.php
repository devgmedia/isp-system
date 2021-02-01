<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PreCustomerProductAdditional extends Pivot
{
    public $incrementing = true;
    protected $table = 'pre_customer_product_additional';

    protected $attributes = [
        'first_month_not_billed' => false,
        'corrected' => false,
    ];

    protected $fillable = [
        // 'id',
        'sid',
        'sid_mapping',
        'registration_date',
        'pre_customer_product_id',
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
        
        'corrected',
        'first_month_not_billed',
        
        'adjusted_price',
        'special_price',
        
        'adjusted_quantity',
        'quantity',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'sid' => 'string',
        'sid_mapping' => 'string',
        'registration_date' => 'date:Y-m-d',
        'pre_customer_product_id' => 'integer',
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
        
        'corrected' => 'boolean',
        'first_month_not_billed' => 'boolean',

        'adjusted_price' => 'boolean',
        'special_price' => 'integer',

        'adjusted_quantity' => 'boolean',
        'quantity' => 'integer',
    ];

    public function pre_customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function product_additional()
    {
        return $this->belongsTo(ProductAdditional::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function media_vendor()
    {
        return $this->belongsTo(MediaVendor::class);
    }

    public function dependency()
    {
        return $this->belongsTo(PreCustomerProductAdditional::class, 'dependency');
    }

    public function required_by()
    {
        return $this->hasMany(preCustomerProductAdditional::class, 'dependency');
    }

    public function invoice_scheme_additional()
    {
        return $this->hasOne(ArInvoiceSchemeCustomerProductAdditional::class, 'pre_customer_product_additional_id');
    }

    public function invoice_additionals()
    {
        return $this->hasMany(ArInvoiceCustomerProductAdditional::class, 'pre_customer_product_additional_id');
    }
}
