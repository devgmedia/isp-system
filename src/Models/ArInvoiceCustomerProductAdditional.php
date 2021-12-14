<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceCustomerProductAdditional extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_customer_product_additional';

    protected $attributes = [
        'price' => 0,
        'discount' => 0,
        'tax' => 0,
        'tax_base' => 0,
        'total' => 0,
    ];

    protected $fillable = [
        // 'id',
        'ar_invoice_customer_product_id',
        'customer_product_additional_id',
        'customer_product_additional_name',
        'customer_product_additional_price',
        'customer_product_additional_price_include_tax',
        'customer_product_additional_payment_scheme_id',
        'customer_product_additional_payment_scheme_name',
        'customer_product_additional_bandwidth',
        'customer_product_additional_bandwidth_unit_id',
        'customer_product_additional_bandwidth_unit_name',

        'created_at',
        'updated_at',

        'billing_start_date',
        'billing_end_date',

        'price',
        'discount',
        'tax',
        'tax_base',
        'total',

        'customer_product_additional_bandwidth_type_id',
        'customer_product_additional_bandwidth_type_name',

        'ar_invoice_customer_id',

        'billing_date',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_customer_product_id' => 'integer',
        'customer_product_additional_id' => 'integer',
        'customer_product_additional_name' => 'string',
        'customer_product_additional_price' => 'integer',
        'customer_product_additional_price_include_tax' => 'boolean',
        'customer_product_additional_payment_scheme_id' => 'integer',
        'customer_product_additional_payment_scheme_name' => 'string',
        'customer_product_additional_bandwidth' => 'integer',
        'customer_product_additional_bandwidth_unit_id' => 'integer',
        'customer_product_additional_bandwidth_unit_name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'billing_start_date' => 'date:Y-m-d',
        'billing_end_date' => 'date:Y-m-d',

        'price' => 'double',
        'discount' => 'double',
        'tax' => 'double',
        'tax_base' => 'double',
        'total' => 'double',

        'customer_product_additional_bandwidth_type_id' => 'integer',
        'customer_product_additional_bandwidth_type_name' => 'string',

        'ar_invoice_customer_id' => 'integer',

        'billing_date' => 'date:Y-m-d',
    ];

    public function invoice_customer_product()
    {
        return $this->belongsTo(ArInvoiceCustomerProduct::class, 'ar_invoice_customer_product_id');
    }

    public function customer_product_additional()
    {
        return $this->belongsTo(CustomerProductAdditional::class);
    }

    public function scheme_customer_product_additional()
    {
        return $this->belongsTo(ArInvoiceSchemeCustomerProductAdditional::class);
    }

    public function customer_product_additional_payment_scheme()
    {
        return $this->belongsTo(PaymentScheme::class);
    }

    public function customer_product_additional_bandwidth_unit()
    {
        return $this->belongsTo(BandwidthUnit::class);
    }

    public function customer_product_additional_bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }

    public function invoice_customer()
    {
        return $this->belongsTo(ArInvoiceCustomer::class, 'ar_invoice_customer_id');
    }
}
