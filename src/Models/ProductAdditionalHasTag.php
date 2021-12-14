<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAdditionalHasTag extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'product_additional_has_tag';

    protected $fillable = [
        // 'id',
        'product_additional_id',
        'tag_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'product_additional_id' => 'integer',
        'tag_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
