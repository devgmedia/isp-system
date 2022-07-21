<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceMidtrans extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'ar_invoice_midtrans';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',

        'order_id',
        'payment_type',
        'transaction_status',
        'fraud_status',

        'platform',
        'ar_invoice_data',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'string',

        'order_id' => 'string',
        'payment_type' => 'string',
        'transaction_status' => 'string',
        'fraud_status' => 'string',

        'platform' => 'string',
        'ar_invoice_data' => 'string',
    ];

    public function invoice()
    {
        return $this->belongsTo(ArInvoice::class, 'ar_invoice_id');
    }
}
