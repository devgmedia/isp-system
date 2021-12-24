<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceVabca extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_vabca';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',

        'company_code',
        'customer_number',
        'request_id',
        'channel_type',
        'customer_name',
        'currency_code',

        'paid_amount',
        'total_amount',
        
        'transaction_date',

        'flag_advice',
        'sub_company',
        'reference',
        'detail_bills',
        'additional_data',
        'channel_type_description',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'string',
        
        'company_code' => 'string',
        'customer_number' => 'string',
        'request_id' => 'string',
        'channel_type' => 'string',
        'customer_name' => 'string',
        'currency_code' => 'string',

        'paid_amount' => 'double',
        'total_amount' => 'double',
        
        'transaction_date' => 'datetime',

        'flag_advice' => 'string',
        'sub_company' => 'string',
        'reference' => 'string',
        'detail_bills' => 'string',
        'additional_data' => 'string',
        'channel_type_description' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
