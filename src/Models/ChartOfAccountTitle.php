<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccountTitle extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'chart_of_account_title';

    protected $attributes = [];

    protected $fillable = [
        // 'id',
        'name',
        'branch_id',
        
        'created_at',
        'updated_at',

        'effective_date',
        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'effective_date' => 'date',
        'uuid' => 'string',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    function chart_of_accounts()
    {
        return $this->hasMany(ChartOfAccount::class);
    }
}
