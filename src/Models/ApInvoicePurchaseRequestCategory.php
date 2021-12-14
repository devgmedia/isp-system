<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ApInvoicePurchaseRequestCategory extends Model
{
    protected $table = 'ap_invoice_purchase_request_category';

    protected $fillable = [
        // 'id',

        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
