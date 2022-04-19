<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ArInvoiceSettlementInvoice extends Pivot
{
    public $incrementing = true;
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_settlement_invoice';

    protected $attributes = [];

    protected $fillable = [
        // 'id',

        'ar_invoice_settlement_id',
        'ar_invoice_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        
        'ar_invoice_settlement_id' => 'integer',
        'ar_invoice_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ar_invoice_settlement()
    {
        return $this->belongsTo(ArInvoiceSettlement::class);
    }

    public function ar_invoice()
    {
        return $this->belongsTo(ArInvoice::class);
    }
}
