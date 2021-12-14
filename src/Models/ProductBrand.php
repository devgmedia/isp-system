<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'product_brand';

    protected $fillable = [
        // 'id',
        'name',
        
        'created_at',
        'updated_at',

        'type_id',
        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'type_id' => 'integer',
        'uuid' => 'string',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(ProductBrandType::class);
    }
}
