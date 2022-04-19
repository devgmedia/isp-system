<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDiscount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_discount';

    protected $fillable = [
        // 'id',        

        'customer_id',
        'discount_id',

        'start_date',
        'end_date',

        'discount_name',
        'discount_effective_date',
        'discount_expired_date',
        'discount_maximum_use',
        'discount_maximum_use_per_product',
        'discount_maximum_use_per_product_additional',
        'discount_maximum_use_per_customer',
        'discount_maximum_use_per_invoice',
        'discount_scheme_id',
        'discount_type_id',

        'created_at',
        'updated_at',

        'locked_by_bill',

        'corrected',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',        

        'customer_id' => 'integer',
        'discount_id' => 'integer',
        
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',

        'discount_name' => 'string',
        'discount_effective_date' => 'date:Y-m-d',
        'discount_expired_date' => 'date:Y-m-d',
        'discount_maximum_use' => 'integer',
        'discount_maximum_use_per_product' => 'integer',
        'discount_maximum_use_per_product_additional' => 'integer',
        'discount_maximum_use_per_customer' => 'integer',
        'discount_maximum_use_per_invoice' => 'integer',
        'discount_scheme_id' => 'integer',
        'discount_type_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'locked_by_bill' => 'boolean',

        'corrected' => 'boolean',
    ];
}
