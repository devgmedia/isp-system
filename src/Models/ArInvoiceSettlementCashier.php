<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ArInvoiceSettlementCashier extends Pivot
{
    public $incrementing = true;

    protected $connection = 'isp_system';

    protected $table = 'ar_invoice_settlement_cashier';

    protected $attributes = [];

    protected $fillable = [
        // 'id',
        'ar_invoice_settlement_id',

        'cash_bank_id',
        'cashier_in_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_settlement_id' => 'integer',

        'cash_bank_id' => 'integer',
        'cashier_in_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ar_invoice_settlement()
    {
        return $this->belongsTo(ArInvoiceSettlement::class);
    }

    public function cash_bank()
    {
        return $this->belongsTo(CashBank::class);
    }

    public function cashier_in()
    {
        return $this->belongsTo(CashierIn::class);
    }
}
