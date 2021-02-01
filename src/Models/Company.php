<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use GMedia\IspSystem\Models\Regional;

class Company extends Model
{
    protected $table = 'company';

    protected $fillable = [
        // 'id',
        'name',
        'code',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function regionals()
    {
        return $this->hasMany(Regional::class);
    }
}
