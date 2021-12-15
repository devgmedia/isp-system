<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'gender';

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
}
