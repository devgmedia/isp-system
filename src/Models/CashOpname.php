<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CashOpname extends Model
{
    protected $table = 'cash_opname';

    protected $fillable = [
        // 'id',

        'date',
        'cash_bank_id',
        'cash_id',
        'quantity',
        'total',
        'branch_id',

        'created_at',
        'updated_at',

        'chart_of_account_title_id',
        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'date' => 'date:Y-m-d',
        'cash_bank_id' => 'integer',
        'cash_id' => 'integer',
        'quantity' => 'integer',
        'total' => 'double',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'chart_of_account_title_id' => 'integer',
        'uuid' => 'string',
    ];

    public function cash_bank()
    {
        return $this->belongsTo(CashBank::class);
    }

    public function cash()
    {
        return $this->belongsTo(Cash::class);
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
