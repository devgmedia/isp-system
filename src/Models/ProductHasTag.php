<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHasTag extends Model
{
    protected $table = 'product_has_tag';

    protected $fillable = [
        // 'id',
        'product_id',
        'tag_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'tag_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
