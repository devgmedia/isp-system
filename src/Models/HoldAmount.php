<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class HoldAmount extends Model
{
    protected $table = 'hold_amount';

    protected $fillable = [
        // 'id',
        'date',
        'cash_bank_id',
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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }
}
