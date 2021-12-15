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
        'total_port',
        'total_ssid',

        'item_id',
        'olt_id',
        'odp_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'name' => 'string',
        'ip' => 'string',
        'total_port' => 'integer',
        'total_ssid' => 'integer',

        'item_id' => 'integer',
        'olt_id' => 'integer',
        'odp_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function olt_id()
    {
        return $this->belongsTo(Olt::class);
    }

    public function odp_id()
    {
        return $this->belongsTo(Odp::class);
    }
}
