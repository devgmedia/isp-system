<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerHasTag extends Model
{
    protected $table = 'customer_has_tag';

    protected $fillable = [
        // 'id',
        'customer_id',
        'tag_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'customer_id' => 'integer',
        'tag_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
