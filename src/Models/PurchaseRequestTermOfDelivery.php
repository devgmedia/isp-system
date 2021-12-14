<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestTermOfDelivery extends Model
{
    protected $table = 'purchase_request_term_of_delivery';

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
