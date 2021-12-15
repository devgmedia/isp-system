<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoicePaymentList extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_payment_list';

    protected $fillable = [
        'ar_invoice_id',
        'type'
    ];
}
