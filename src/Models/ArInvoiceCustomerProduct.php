<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceCustomerProduct extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'ar_invoice_customer_product';

    protected $attributes = [
        'price' => 0,
        'discount' => 0,
        'tax' => 0,
        'tax_base' => 0,
        'total' => 0,
        'total_usd' => 0,
        'total_sgd' => 0,
    ];

    protected $fillable = [
        // 'id',
        'ar_invoice_customer_id',
        'customer_product_id',

        'created_at',
        'updated_at',

        'ar_invoice_scheme_customer_product_id',

        'customer_product_name',
        'customer_product_price',
        'customer_product_price_include_tax',
        'customer_product_payment_scheme_id',
        'customer_product_payment_scheme_name',
        'customer_product_bandwidth',
        'customer_product_bandwidth_unit_id',
        'customer_product_bandwidth_unit_name',

        'price',
        'discount',
        'tax',
        'tax_base',
        'total',

        'billing_start_date',
        'billing_end_date',

        'customer_product_bandwidth_type_id',
        'customer_product_bandwidth_type_name',

        'billing_date',

        'ar_invoice_item_category_id',

        'total_usd',
        'total_sgd',

        'product_id',
        'product_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_customer_id' => 'integer',
        'customer_product_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'customer_product_name' => 'string',
        'customer_product_price' => 'double',
        'customer_product_price_include_tax' => 'boolean',
        'customer_product_payment_scheme_id' => 'integer',
        'customer_product_payment_scheme_name' => 'string',
        'customer_product_bandwidth' => 'integer',
        'customer_product_bandwidth_unit_id' => 'integer',
        'customer_product_bandwidth_unit_name' => 'string',

        'price' => 'double',
        'discount' => 'double',
        'tax_base' => 'double',
        'tax' => 'double',
        'total' => 'double',

        'billing_start_date' => 'date:Y-m-d',
        'billing_end_date' => 'date:Y-m-d',

        'customer_product_bandwidth_type_id' => 'integer',
        'customer_product_bandwidth_type_name' => 'string',

        'billing_date' => 'date:Y-m-d',

        'ar_invoice_item_category_id' => 'integer',

        'total_usd' => 'double',
        'total_sgd' => 'double',

        'product_id' => 'integer',
        'product_name' => 'string',
    ];

    public function invoice_customer()
    {
        return $this->belongsTo(ArInvoiceCustomer::class, 'ar_invoice_customer_id');
    }

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function scheme_customer_product()
    {
        return $this->belongsTo(ArInvoiceSchemeCustomerProduct::class);
    }

    public function customer_product_payment_scheme()
    {
        return $this->belongsTo(PaymentScheme::class);
    }

    public function customer_product_bandwidth_unit()
    {
        return $this->belongsTo(BandwidthUnit::class);
    }

    public function customer_product_bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }

    public function item_category()
    {
        return $this->belongsTo(ArInvoiceItemCategory::class, 'ar_invoice_item_category_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice_customer_product_additionals()
    {
        return $this->hasMany(ArInvoiceCustomerProductAdditional::class);
    }

    public function invoice_customer_product_discounts()
    {
        return $this->hasMany(ArInvoiceCustomerProductDiscount::class);
    }
}
