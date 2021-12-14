<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CashierIn extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'cashier_in';

    protected $fillable = [
        // 'id',
        'uuid',

        'name',
        'date',
        'total',
        'category_id',
        'branch_id',

        'created_at',
        'updated_at',

        'cash_bank_id',
        
        'petty_cash_top_up',
        'petty_cash_loan',

        'updated_by',

        'chart_of_account_title_id',

        'memo_settlement_id',
        'memo',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',

        'name' => 'string',
        'date' => 'date:Y-m-d',
        'total' => 'double',
        'category_id' => 'integer',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'cash_bank_id' => 'integer',
        
        'petty_cash_top_up' => 'boolean',
        'petty_cash_loan' => 'boolean',

        'updated_by' => 'integer',

        'chart_of_account_title_id' => 'integer',

        'memo_settlement_id' => 'integer',
        'memo' => 'boolean',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function cash_bank()
    {
        return $this->belongsTo(CashBank::class);
    }

    public function category()
    {
        return $this->belongsTo(CashierInCategory::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function updated_by_ref()
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function memo_settlement()
    {
        return $this->belongsTo(ArInvoiceSettlement::class);
    }

    public function journal()
    {
        return $this->hasOne(Journal::class);
    }

    public function journal_cashier_ins()
    {
        return $this->hasMany(JournalCashierIn::class);
    }

    public function journal_items()
    {
        return $this->belongsToMany(JournalItem::class, JournalCashierIn::class)->withPivot('id');
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, JournalCashierIn::class)->withPivot('id');
    }
}
