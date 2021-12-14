<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        // 'id',
        'name',
        'code',

        'created_at',
        'updated_at',

        'alpha_3_code',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'alpha_3_code' => 'string',
    ];

    public function regionals()
    {
        return $this->hasMany(Regional::class);
    }
}
