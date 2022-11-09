<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'service';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
