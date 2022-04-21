<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class BandwidthUnit extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'bandwidth_unit';

    protected $fillable = [
        //'id',
        'name',
        'uuid',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'uuid' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
