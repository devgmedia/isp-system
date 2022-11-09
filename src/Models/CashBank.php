<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CashBank extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'cash_bank';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'number',
        'on_behalf_of',
        'branch_id',
        'chart_of_account_id',
        'chart_of_account_card_id',
        'created_at',
        'updated_at',

        'is_cash',
        'is_petty_cash',

        'daily_cash_bank_report',

        'chart_of_account_title_id',

        'bank_id',
        'bank_branch',

        'erp1_id',
        'is_virtual_account',
        'code',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'number' => 'string',
        'on_behalf_of' => 'string',
        'branch_id' => 'integer',
        'chart_of_account_id' => 'integer',
        'chart_of_account_card_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'is_cash' => 'boolean',
        'is_petty_cash' => 'boolean',

        'daily_cash_bank_report' => 'boolean',

        'chart_of_account_title_id' => 'integer',

        'bank_id' => 'integer',
        'bank_branch' => 'string',

        'erp1_id' => 'integer',
        'is_virtual_account' => 'boolean',
        'code' => 'string',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setOnBehalfOfAttribute($value)
    {
        $this->attributes['on_behalf_of'] = ucfirst($value);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountCard::class);
    }

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function chart_of_account_card()
    {
        return $this->belongsTo(ChartOfAccountCard::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function cash_opnames()
    {
        return $this->hasMany(CashOpname::class);
    }
}
