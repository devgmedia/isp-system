<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class JournalCode extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'journal_code';

    protected $fillable = [
        // 'id',
        'name',

        'created_at',
        'updated_at',

        'branch_id',
        'chart_of_account_title_id',

        'type_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',

        'type_id' => 'integer',
    ];

    public function type()
    {
        return $this->belongsTo(JournalType::class);
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
