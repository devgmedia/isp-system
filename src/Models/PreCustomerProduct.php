<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PreCustomerProduct extends Pivot
{
    public $incrementing = true;

    protected $connection = 'isp_system';

    protected $table = 'pre_customer_product';

    protected $fillable = [
        // 'id',

        'pre_customer_id',
        'product_id',

        'media_id',
        'media_vendor_id',

        'created_at',
        'updated_at',

        'agent_id',
        'sales',

        'public_facility',

        'tax',
        'product_name',
        'product_price',
        'product_price_usd',
        'product_price_sgd',

        'retail_coverage',
        'retail_validation',
        'retail_status',

        'radius_username',
        'radius_password',

        'sid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'pre_customer_id' => 'integer',
        'product_id' => 'integer',

        'media_id' => 'integer',
        'media_vendor_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'agent_id' => 'integer',
        'sales' => 'integer',

        'public_facility' => 'boolean',

        'tax' => 'boolean',
        'product_name' => 'string',
        'product_price' => 'integer',
        'product_price_usd' => 'integer',
        'product_price_sgd' => 'integer',

        'retail_coverage' => 'boolean',
        'retail_validation' => 'boolean',
        'retail_status' => 'string',

        'radius_username' => 'string',
        'radius_password' => 'string',

        'sid' => 'string',
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

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function sales_ref()
    {
        return $this->belongsTo(Employee::class, 'sales');
    }
}
