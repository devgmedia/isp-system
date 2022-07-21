<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Pon extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'pon';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'rack',
        'shelf',
        'slot',
        'olt_id',
        'item_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'rack' => 'string',
        'shelf' => 'string',
        'slot' => 'string',
        'olt_id' => 'integer',
        'item_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function olt()
    {
        return $this->belongsTo(Olt::class);
    }
}
