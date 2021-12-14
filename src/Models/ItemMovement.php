<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemMovementList;

class ItemMovement extends Model
{
    protected $table = 'item_movement';

    protected $fillable = [
        // 'id',

        'date',
        'time',
        'created_by',
        'created_name',
        'created_date',

        'warehouse_approved_by',
        'warehouse_approved_name',
        'warehouse_apporved_date',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'date' => 'date',
        'time' => 'time',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function movement_list()
    {
        return $this->hasMany(ItemMovementList::class,'movement_id');
    }

    // public function item()
    // {
    //     return $this->belongsTo(Item::class);
    // }
}
