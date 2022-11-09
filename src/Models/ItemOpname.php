<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemOpname extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'item_opname';

    protected $fillable = [
        // 'id',
        'available',
        'total',
        'item_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'available' => 'integer',
        'total' => 'integer',
        'item_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item_types()
    {
        return $this->hasMany(Item::class, 'item_id');
    }
}
