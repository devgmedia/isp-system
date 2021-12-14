<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceCustomerDiscount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_customer_discount';

    protected $fillable = [
        // 'id',
        'ar_invoice_customer_id',
        'customer_discount_id',

        'created_at',
        'updated_at',

        'customer_discount_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_customer_id' => 'integer',
        'customer_discount_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'customer_discount_name' => 'string',
    ];
}
