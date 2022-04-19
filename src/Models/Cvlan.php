<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Cvlan extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'cvlan';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'id_cvlan',
        'index',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'id_cvlan' => 'integer',
        'index' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
