<?php

namespace Gmedia\IspSystem\Models;

use Gmedia\IspSystem\Models\ProductAdditional;
use Illuminate\Database\Eloquent\Model;

class ProductAdditionalTag extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'product_additional_tag';

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

    public function additionals()
    {
        return $this->belongsToMany(ProductAdditional::class, ProductAdditionalHasTag::class, 'tag_id', 'product_additional_id');
    }
}
