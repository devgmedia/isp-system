<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccountCard extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'chart_of_account_card';

    protected $attributes = [];

    protected $fillable = [
        // 'id',
        'name',
        'equation',
        'chart_of_account_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'equation' => 'integer',
        'chart_of_account_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function equation_ref()
    {
        return $this->belongsTo(AccountingEquation::class);
    }

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}
