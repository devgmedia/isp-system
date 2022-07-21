<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodCategory extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'payment_method_category';

    protected $fillable = [
        // 'id',
        'name',
        'slug',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'slug' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
