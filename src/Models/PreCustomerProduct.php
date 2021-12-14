<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PreCustomerProduct extends Pivot
{
    public $incrementing = true;
    protected $table = 'pre_customer_product';

    protected $fillable = [
        // 'id',
        'pre_customer_id',
        'product_id',
        'media_id',
        'media_vendor_id',

        'custom_site_information',
        'site_name',
        'site_province_id',
        'site_district_id',
        'site_sub_district_id',
        'site_village_id',
        'site_address',
        'site_postal_code',
        'site_latitude',
        'site_longitude', 

        'adjusted_price',
        'special_price',
        
        'adjusted_bandwidth',
        'special_bandwidth',

        'ignore_tax',
        'ignore_prorated',
        'postpaid',

        'custom_billing_information',
        'billing_name',
        'billing_province_id',
        'billing_district_id',
        'billing_sub_district_id',
        'billing_village_id',
        'billing_address',
        'billing_postal_code',
        'billing_latitude',
        'billing_longitude', 

        'agent_id',
        'sales',  

        'join_billing_id',

        'created_at',
        'updated_at', 

        'elevasi',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'pre_customer_id' => 'integer',
        'product_id' => 'integer',
        'media_id' => 'integer',
        'media_vendor_id' => 'integer',

        'custom_site_information' => 'boolean',
        'site_name' => 'string',
        'site_province_id' => 'integer',
        'site_district_id' => 'integer',
        'site_sub_district_id' => 'integer',
        'site_village_id' => 'integer',
        'site_address' => 'string',
        'site_postal_code' => 'string',
        'site_latitude' => 'double',
        'site_longitude' => 'double', 

        'adjusted_price' => 'boolean',
        'special_price' => 'integer',

        'adjusted_bandwidth' => 'boolean',
        'special_bandwidth' => 'integer',

        'ignore_tax' => 'boolean',
        'ignore_prorated' => 'boolean',
        'postpaid' => 'boolean',

        'custom_billing_information' => 'boolean',
        'billing_name' => 'string',
        'billing_province_id' => 'integer',
        'billing_district_id' => 'integer',
        'billing_sub_district_id' => 'integer',
        'billing_village_id' => 'integer',
        'billing_address' => 'string',
        'billing_postal_code' => 'string',
        'billing_latitude' => 'double', 
        'billing_longitude' => 'double', 
        
        'agent_id' => 'integer',
        'sales' => 'integer',
        
        'join_billing_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        
        'elevasi' => 'string',
    ];

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
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

    public function pre_customer_product_additionals()
    {
        return $this->hasMany(PreCustomerProductAdditional::class, 'pre_customer_product_id');
    }

    public function additionals()
    {
        return $this->belongsToMany(ProductAdditional::class, PreCustomerProductAdditional::class, 'pre_customer_product_id', 'product_additional_id')->withPivot('id');
    }

    public function pre_customer_product_discounts()
    {
        return $this->hasMany(PreCustomerProductDiscount::class, 'pre_customer_product_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(ProductDiscount::class, PreCustomerProductDiscount::class, 'pre_customer_product_id', 'product_discount_id')->withPivot('id');
    }

    public function pre_customer_product_site_phone_numbers()
    {
        return $this->hasMany(PreCustomerProductSitePhoneNumber::class, 'pre_customer_product_id');
    }

    public function pre_customer_product_site_emails()
    {
        return $this->hasMany(PreCustomerProductSiteEmail::class, 'pre_customer_product_id');
    }

    public function pre_customer_product_billing_phone_numbers()
    {
        return $this->hasMany(PreCustomerProductBillingPhoneNumber::class, 'pre_customer_product_id');
    }

    public function pre_customer_product_billing_emails()
    {
        return $this->hasMany(PreCustomerProductBillingEmail::class, 'pre_customer_product_id');
    }
}
