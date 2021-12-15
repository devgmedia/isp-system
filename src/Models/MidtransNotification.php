<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class MidtransNotification extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'midtrans_notification';

    protected $fillable = [
        // 'id',

        'order_id',
        'transaction_status',
        'payment_type',
        'fraud_status',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        
        'order_id' => 'string',
        'transaction_status' => 'string',
        'payment_type' => 'string',
        'fraud_status' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
