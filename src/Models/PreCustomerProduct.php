<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use  GMedia\IspSystem\Models\PreCustomer;
use  GMedia\IspSystem\Models\Product;
use  GMedia\IspSystem\Models\Media;
use  GMedia\IspSystem\Models\MediaVendor;
use  GMedia\IspSystem\Models\CustomerProductAdditional;
use  GMedia\IspSystem\Models\ArInvoiceCustomerProduct;

class PreCustomerProduct extends Pivot
{
    public $incrementing = true;
    protected $table = 'pre_customer_product';

    protected $attributes = [
        'first_month_not_billed' => false,
        'corrected' => false,
    ];

    protected $fillable = [
        // 'id',
        'pre_customer_id',
        'product_id',

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
        'pre_customer_id' => 'integer',
        'product_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'adjusted_price' => 'integer',
        'special_price' => 'integer',
        'adjusted_quantity' => 'integer',
        'quantity' => 'integer',
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

    public function dependency()
    {
        return $this->belongsTo(PreCustomerProduct::class, 'dependency');
    }

    public function required_by()
    {
        return $this->hasMany(PreCustomerProduct::class, 'dependency');
    }

    public function pre_customer_product_additionals()
    {
        return $this->hasMany(PreCustomerProductAdditional::class, 'pre_customer_product_id');
    }

    public function additionals()
    {
        return $this->belongsToMany(ProductAdditional::class, PreCustomerProductAdditional::class, 'pre_customer_product_id', 'product_additional_id')->withPivot('id');
    }

    public function Precustomer_product_discounts()
    {
        return $this->hasMany(PreCustomerProductDiscount::class, 'pre_customer_product_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(ProductDiscount::class, PreCustomerProductDiscount::class, 'pre_customer_product_id', 'product_discount_id')->withPivot('id');
    }

    public function invoice_scheme_product()
    {
        return $this->hasOne(ArInvoiceSchemeCustomerProduct::class, 'pre_customer_product_id');
    }

    public function invoice_products()
    {
        return $this->hasMany(ArInvoiceCustomerProduct::class, 'pre_customer_product_id');
    }
}
