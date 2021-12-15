<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArInvoicePayment extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_payment';

    protected $fillable = [
        'ar_invoice_id',
        'date',
        'amount'
    ];

    protected $dates = ['deleted_at'];
}
