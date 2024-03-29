<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class JournalProject extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'journal_project';

    protected $fillable = [
        // 'id',
        'name',
        'branch_id',

        'created_at',
        'updated_at',

        'chart_of_account_title_id',
        'default_on_pra_gl_ar',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'chart_of_account_title_id' => 'integer',
        'default_on_pra_gl_ar' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }
}
