<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingDivisionCategory extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'accounting_division_category';

    protected $fillable = [
        // 'id',

        'name',
        'branch_id',
        'chart_of_account_title_id',

        'created_at',
        'updated_at',

        'default_on_pra_gl_ar',

        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',
        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'default_on_pra_gl_ar' => 'boolean',

        'uuid',
    ];

    function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }
}
