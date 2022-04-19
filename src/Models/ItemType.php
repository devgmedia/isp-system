<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'item_type';

    protected $fillable = [
        // 'id',

        'name',
        'brand_id',
        'brand_product_id', 
        'discontinue_date', 
        'discontinue_name', 
        'discontinue_by', 
        'uuid',
        'created_at',
        'updated_at', 
    ];

    protected $hidden = [];

    protected $casts = [
        // 'id' => 'integer',

        'name' => 'string',
        'brand_id' => 'integer',
        'brand_product_id' => 'integer', 
        'uuid' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime', 
    ];

    public function brand()
    {
        return $this->belongsTo(ItemBrand::class);
    }

    public function brand_product()
    {
        return $this->belongsTo(ItemBrandProduct::class);
    }  

    public function quality_control()
    {
        return $this->hasMany(ItemTypeQualityControl::class);
    }
}
