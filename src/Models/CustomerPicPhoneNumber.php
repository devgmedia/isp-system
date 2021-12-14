<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPicPhoneNumber extends Model
{
    protected $table = 'customer_pic_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'customer_pic_id',
        'customer_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'customer_pic_id' => 'integer',
        'customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
