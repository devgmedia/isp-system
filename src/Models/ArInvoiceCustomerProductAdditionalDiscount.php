<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceCustomerProductAdditionalDiscount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_customer_product_additional_discount';

    protected $fillable = [
        // 'id',
        'ar_invoice_customer_product_additional_id',
        'customer_product_additional_discount_id',

        'created_at',
        'updated_at',

        'customer_product_additional_discount_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_customer_product_additional_id' => 'integer',
        'customer_product_additional_discount_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'customer_product_additional_discount_name' => 'string',
    ];
}
