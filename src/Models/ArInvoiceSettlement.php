<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceSettlement extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_settlement';

    protected $fillable = [
        // 'id',

        'uuid',
        'ar_invoice_id',

        'branch_id',

        'created_at',
        'updated_at',

        'chart_of_account_title_id',

        'date',        
        'memo',
        'memo_confirm',

        'invoice',
        'admin',
        'down_payment',
        'marketing_fee',
        'pph_pasal_22',
        'pph_pasal_23',
        'ppn',

        'total',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'ar_invoice_id' => 'integer',
        
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'chart_of_account_title_id' => 'integer',

        'date' => 'date:Y-m-d',
        'memo' => 'double',
        'memo_confirm' => 'boolean',

        'invoice' => 'double',
        'admin' => 'double',
        'down_payment' => 'double',
        'marketing_fee' => 'double',
        'pph_pasal_22' => 'double',
        'pph_pasal_23' => 'double',
        'ppn' => 'double',

        'total' => 'double',
    ];

    public function ar_invoice()
    {
        return $this->belongsTo(ArInvoice::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }
}
