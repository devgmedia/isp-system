<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'payment_method';

    protected $fillable = [
        // 'id',
        'name',
        'payment_method_category_id',
        'description',
        'icon',
        'slug',
        'active',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',
        'payment_method_category_id' => 'integer',
        'description' => 'text',
        'icon' => 'text',
        'slug' => 'string',
        'active' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
