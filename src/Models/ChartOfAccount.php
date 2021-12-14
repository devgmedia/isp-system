<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'chart_of_account';

    protected $attributes = [];

    protected $fillable = [
        // 'id',
        'code',
        'name',
        'equation',
        'parent',
        
        'created_at',
        'updated_at',

        'title_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'equation' => 'integer',
        'parent' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'title_id' => 'integer',
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function equation_ref()
    {
        return $this->belongsTo(AccountingEquation::class);
    }

    public function parent_ref()
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(ChartOfAccount::class, 'parent');
    }

    public function title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }
}
