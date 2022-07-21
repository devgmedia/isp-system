<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemMacAddress extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'item_mac_address';

    protected $fillable = [
        // 'id',

        'item_id',
        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'item_id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
