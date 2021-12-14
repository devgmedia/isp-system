<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceTransaction extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_transaction';

    protected $fillable = [
        // 'id',

        'name',
        'alias_name',

        'branch_id',
        'chart_of_account_title_id',

        'lock',

        'created_at',
        'updated_at',

        'debit_coa_id',
        'debit_coa_card_id',

        'credit_coa_id',
        'credit_coa_card_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',
        'alias_name' => 'string',
        
        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',

        'lock' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'debit_coa_id' => 'integer',
        'debit_coa_card_id' => 'integer',

        'credit_coa_id' => 'integer',
        'credit_coa_card_id' => 'integer',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function debit_coa()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function debit_coa_card()
    {
        return $this->belongsTo(ChartOfAccountCard::class);
    }

    public function credit_coa()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function credit_coa_card()
    {
        return $this->belongsTo(ChartOfAccountCard::class);
    }
}
