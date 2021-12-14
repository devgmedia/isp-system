<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductTag extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'product_tag';

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

    public function products()
    {
        return $this->belongsToMany(Product::class, ProductHasTag::class, 'tag_id', 'product_id');
    }
}
