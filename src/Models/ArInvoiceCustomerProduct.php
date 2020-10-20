<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceCustomerProduct extends Model
{
    protected $table = 'ar_invoice_customer_product';

    protected $attributes = [
        'price' => 0,
        'discount' => 0,
        'ppn' => 0,
        'dpp' => 0,
        'total' => 0,
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
        'customer_product_price_include_vat',
        'customer_product_payment_scheme_id',
        'customer_product_payment_scheme_name',
        'customer_product_bandwidth',
        'customer_product_bandwidth_unit_id',
        'customer_product_bandwidth_unit_name',

        'price',
        'discount',
        'ppn',
        'dpp',
        'total',

        'billing_start_date',
        'billing_end_date',

        'customer_product_bandwidth_type_id',
        'customer_product_bandwidth_type_name',

        'billing_date',
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
        'customer_product_price_include_vat' => 'boolean',
        'customer_product_payment_scheme_id' => 'integer',
        'customer_product_payment_scheme_name' => 'string',
        'customer_product_bandwidth' => 'integer',
        'customer_product_bandwidth_unit_id' => 'integer',
        'customer_product_bandwidth_unit_name' => 'string',

        'price' => 'double',
        'discount' => 'double',
        'ppn' => 'double',
        'total' => 'double',

        'billing_start_date' => 'date:Y-m-d',
        'billing_end_date' => 'date:Y-m-d',

        'customer_product_bandwidth_type_id' => 'integer',
        'customer_product_bandwidth_type_name' => 'string',
        
        'billing_date' => 'date:Y-m-d',
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

    public function invoice_customer_product_additionals()
    {
        return $this->hasMany(ArInvoiceCustomerProductAdditional::class);
    }

    public function invoice_customer_product_discounts()
    {
        return $this->hasMany(ArInvoiceCustomerProductDiscount::class);
    }
}
