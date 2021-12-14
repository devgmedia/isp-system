<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'odp';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'item_id',
        'olt_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'item_id' => 'integer',
        'olt_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
