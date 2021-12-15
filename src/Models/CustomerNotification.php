<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerNotification extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_notification';

    protected $fillable = [
        // 'id',

        'title',
        'message',
        'date',
        'ar_invoice_id',
        'customer_id',
        'read_at',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        
        'title' => 'string',
        'message' => 'string',
        'date' => 'datetime',
        'ar_invoice_id' => 'integer',
        'customer_id' => 'integer',
        'read_at' => 'datetime',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
