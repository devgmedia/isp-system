<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ApInvoiceTransaction extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ap_invoice_transaction';

    protected $fillable = [
        // 'id',

        'name',        
        'branch_id',
        'chart_of_account_title_id',

        'lock',

        'created_at',
        'updated_at',

        'debit_coa_id',
        'debit_coa_card_id',

        'credit_coa_id',
        'credit_coa_card_id',

        'alias_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',
        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',

        'lock' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'debit_coa_id' => 'integer',
        'debit_coa_card_id' => 'integer',

        'credit_coa_id' => 'integer',
        'credit_coa_card_id' => 'integer',

        'alias_name' => 'string',
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
