<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Odc extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'odc';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'item_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'item_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function otb()
    {
        return $this->belongsTo(Otb::class);
    }
}
