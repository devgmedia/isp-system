<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProduct extends Pivot
{
    public $incrementing = true;
    protected $table = 'customer_product';

    protected $attributes = [
        'first_month_not_billed' => false,
        'corrected' => false,
    ];

    protected $fillable = [
        // 'id',
        'sid',
        'sid_mapping',
        'registration_date',
        'customer_id',
        'product_id',
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

        'service_date',
        'billing_date',

        'site_province_id',
        'site_district_id',
        'site_sub_district_id',
        'site_village_id',
        'site_address',
        'site_latitude',
        'site_logitude',

        'agent_id',
        'sales',
        'customer_relation',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'sid' => 'string',
        'sid_mapping',
        'registration_date' => 'date:Y-m-d',
        'customer_id' => 'integer',
        'product_id' => 'integer',
        'media_id' => 'integer',
        'media_vendor_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'service_end_date' => 'date:Y-m-d',
        'service_start_date' => 'date:Y-m-d',
        'billing_start_date' => 'date:Y-m-d',
        'billing_end_date' => 'date:Y-m-d',

        'dependency' => 'integer',
        
        'corrected' => 'boolean',
        'first_month_not_billed' => 'boolean',

        'service_date' => 'date:Y-m-d',
        'billing_date' => 'date:Y-m-d',

        'site_province_id' => 'integer',
        'site_district_id' => 'integer',
        'site_sub_district_id' => 'integer',
        'site_village_id' => 'integer',
        'site_address' => 'string',
        'site_latitude' => 'double',
        'site_logitude' => 'double',

        'agent_id' => 'integer',
        'sales' => 'integer',
        'customer_relation' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
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
        return $this->belongsTo(CustomerProduct::class, 'dependency');
    }

    public function required_by()
    {
        return $this->hasMany(CustomerProduct::class, 'dependency');
    }

    public function customer_product_additionals()
    {
        return $this->hasMany(CustomerProductAdditional::class, 'customer_product_id');
    }

    public function additionals()
    {
        return $this->belongsToMany(ProductAdditional::class, CustomerProductAdditional::class, 'customer_product_id', 'product_additional_id')->withPivot('id');
    }

    public function customer_product_discounts()
    {
        return $this->hasMany(CustomerProductDiscount::class, 'customer_product_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(ProductDiscount::class, CustomerProductDiscount::class, 'customer_product_id', 'product_discount_id')->withPivot('id');
    }

    public function invoice_scheme_product()
    {
        return $this->hasOne(ArInvoiceSchemeCustomerProduct::class, 'customer_product_id');
    }

    public function invoice_products()
    {
        return $this->hasMany(ArInvoiceCustomerProduct::class, 'customer_product_id');
    }

    public function site_province()
    {
        return $this->belongsTo(Province::class, 'site_province_id');
    }

    public function site_district()
    {
        return $this->belongsTo(Province::class, 'site_province_id');
    }

    public function site_sub_district()
    {
        return $this->belongsTo(Province::class, 'site_province_id');
    }

    public function site_village()
    {
        return $this->belongsTo(Province::class, 'site_province_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
