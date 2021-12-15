<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'kasbon';

    protected $fillable = [
        // 'id',

        'date',
        'name',
        'total',
        'branch_id',

        'created_at',
        'updated_at',

        'chart_of_account_title_id',

        'cash_bank_id',
        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'date' => 'date:Y-m-d',
        'name' => 'string',
        'total' => 'double',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'chart_of_account_title_id' => 'integer',

        'cash_bank_id' => 'integer',
        'uuid' => 'string',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function cash_bank()
    {
        return $this->belongsTo(CashBank::class);
    }
}
