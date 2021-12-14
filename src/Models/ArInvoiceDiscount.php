<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceDiscount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_discount';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',
        'discount_id',

        'discount_name',
        'discount_effective_date',
        'discount_expired_date',
        'discount_maximum_use',
        'discount_maximum_use_per_product',
        'discount_maximum_use_per_product_additional',
        'discount_maximum_use_per_customer',
        'discount_maximum_use_per_invoice',
        'discount_scheme_id',
        'discount_type_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'integer',
        'discount_id' => 'integer',

        'discount_name' => 'string',
        'discount_effective_date' => 'date:Y-m-d',
        'discount_expired_date' => 'date:Y-m-d',
        'discount_maximum_use' => 'integer',
        'discount_maximum_use_per_product' => 'integer',
        'discount_maximum_use_per_product_additional' => 'integer',
        'discount_maximum_use_per_customer' => 'integer',
        'discount_maximum_use_per_invoice' => 'integer',
        'discount_scheme_id' => 'integer',
        'discount_type_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
