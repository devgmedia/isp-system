<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemBrand extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'item_brand';

    protected $fillable = [
        // 'id',
        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item_brand_products()
    {
        return $this->hasMany(ItemBrandProduct::class, 'brand_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'brand_id');
    }
}
