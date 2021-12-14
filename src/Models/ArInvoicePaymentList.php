<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoicePaymentList extends Model
{
    protected $table = 'ar_invoice_payment_list';

    protected $fillable = [
        'ar_invoice_id',
        'type'
    ];
}
