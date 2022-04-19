<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodType extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'payment_method_type';

    protected $fillable = [
        // 'id',
        'name',
        'payment_method_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',
        'payment_method_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
