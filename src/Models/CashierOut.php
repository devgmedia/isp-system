<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CashierOut extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'cashier_out';

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

        'petty_cash_loan_return',

        'updated_by',

        'chart_of_account_id',

        'accounting_division_category_id',

        'chart_of_account_title_id',

        'memo_spm_id',
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

        'petty_cash_loan_return' => 'boolean',

        'updated_by' => 'integer',

        'chart_of_account_id' => 'integer',

        'accounting_division_category_id' => 'integer',

        'chart_of_account_title_id' => 'integer',
        
        'memo_spm_id' => 'integer',
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
        return $this->belongsTo(CashierOutCategory::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function updated_by_ref()
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function accounting_division_category()
    {
        return $this->belongsTo(AccountingDivisionCategory::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function memo_spm()
    {
        return $this->belongsTo(Spm::class);
    }

    public function journal()
    {
        return $this->hasOne(Journal::class);
    }

    public function journal_cashier_outs()
    {
        return $this->hasMany(JournalCashierOut::class);
    }

    public function journal_items()
    {
        return $this->belongsToMany(JournalItem::class, JournalCashierOut::class)->withPivot('id');
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, JournalCashierOut::class)->withPivot('id');
    }
}
