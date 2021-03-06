<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerProductAdditionalDiscount extends Model
{
    protected $table = 'pre_customer_product_additional_discount';

    protected $fillable = [
        // 'id',

        'registration_date',
        'pre_customer_product_additional_id',
        'product_additional_discount_id',
        'start_date',
        'end_date',

        'created_at',
        'updated_at',

        'corrected',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
    
        'registration_date' => 'date:Y-m-d',
        'pre_customer_product_additional_id' => 'integer',
        'product_additional_discount_id' => 'integer',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'corrected' => 'boolean',
    ];
}
