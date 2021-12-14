<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestStatus extends Model
{
    protected $table = 'purchase_request_status';

    protected $fillable = [
        // 'id',
        'name',
        'description',
        'step',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'step'	=> 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
