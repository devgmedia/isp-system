<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class BandwidthType extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'bandwidth_type';

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
