<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Bts;
use App\Models\Item;

class BtsItem extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'bts_item';

    protected $fillable = [
       'item_id',
       'bts_id',
       'created_at',
       'updated_at',
    ];

    protected $casts = [
       'item_id' => 'integer',
       'bts_id' => 'integer',
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
    ];

    public function Bts()
    {
        return $this->belongsTo(Bts::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
