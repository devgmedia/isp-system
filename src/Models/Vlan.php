<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Vlan extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'vlan';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'id_vlan_customer',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',

        'name' => 'string',
        'id_vlan_customer' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
