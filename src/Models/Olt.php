<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Olt extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'olt';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'ip',
        'item_id',

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

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
