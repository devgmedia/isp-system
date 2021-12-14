<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class JournalTag extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'journal_tag';

    protected $fillable = [
        // 'id',
        'name',

        'created_at',
        'updated_at',

        'branch_id',
        'chart_of_account_title_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        
        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',
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
