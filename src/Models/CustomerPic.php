<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPic extends Model
{
    protected $table = 'customer_pic';

    protected $fillable = [
        // 'id',
        'name',
        'customer_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
