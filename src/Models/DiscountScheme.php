<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountScheme extends Model
{
    protected $table = 'discount_scheme';

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
}
