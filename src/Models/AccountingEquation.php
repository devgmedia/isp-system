<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingEquation extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'accounting_equation';

    protected $attributes = [];

    protected $fillable = [
        // 'id',
        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function chart_of_accounts()
    {
        return $this->hasMany(ChartOfAccount::class);
    }
}
