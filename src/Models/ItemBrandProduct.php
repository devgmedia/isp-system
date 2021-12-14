<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBrandProduct extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'item_brand_product';

    protected $fillable = [
        // 'id',
        'name',
        'brand_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'brand_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item_brand()
    {
        return $this->belongsTo(ItemBrand::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'brand_product_id');
    }
}
