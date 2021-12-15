<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArInvoiceAccountNumber extends Model
{
    protected $connection = 'isp_system';

    use SoftDeletes;

    protected $table = 'ar_invoice_v2_account_number';

    protected $fillable = [
        'ar_invoice_id',
        'bank_account_id'
    ];

    protected $dates = ['deleted_at'];
}
