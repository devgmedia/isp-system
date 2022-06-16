<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Onu extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'onu';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'ip',
        'item_id',
        'odp_id',
        'onu_type_id',
        'index',
        'serial_number',
        'distance',
        'onu_password',

        'cvlan_mgmt',
        'cvlan_user',
        'svlan_mgmt',
        'svlan_user',
        'customer_product_id',

        'vlan_id',

        'date',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'name' => 'string',
        'ip' => 'string',
        'item_id' => 'integer',
        'odp_id' => 'integer',
        'onu_type_id' => 'integer',
        'index' => 'integer',
        'serial_number' => 'string',
        'distance' => 'integer',
        'onu_password' => 'string',

        'cvlan_mgmt' => 'string',
        'cvlan_user' => 'string',
        'svlan_mgmt' => 'string',
        'svlan_user' => 'string',
        'customer_product_id' => 'integer',

        'vlan_id' => 'integer',

        'date' => 'date:Y-m-d',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function odp()
    {
        return $this->belongsTo(Odp::class);
    }
}
