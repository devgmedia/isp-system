<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductAdditionalDiscount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_product_additional_discount';

    protected $fillable = [
        // 'id',

        'customer_product_additional_id',
        'product_additional_discount_id',

        'start_date',
        'end_date',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',    

        'customer_product_additional_id' => 'integer',
        'product_additional_discount_id' => 'integer',
        
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
