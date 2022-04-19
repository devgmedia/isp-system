<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodGuide extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'payment_method_guide';

    protected $fillable = [
        // 'id',
        'payment_method_type_id',
        'number',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'payment_method_type_id' => 'integer',
        'number' => 'integer',
        'description' => 'text',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
