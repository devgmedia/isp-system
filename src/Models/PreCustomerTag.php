<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerTag extends Model
{
    protected $table = 'pre_customer_tag';

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
