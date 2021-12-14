<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerPicPhoneNumber extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_pic_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'pre_customer_pic_id',
        'pre_customer_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'pre_customer_pic_id' => 'integer',
        'pre_customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
