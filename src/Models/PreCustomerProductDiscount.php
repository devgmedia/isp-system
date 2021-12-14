<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PreCustomerProductDiscount extends Pivot
{
    public $incrementing = true;
    protected $table = 'pre_customer_product_discount';

    protected $attributes = [];

    protected $fillable = [
        // 'id',
 
        'pre_customer_product_id',
        'product_discount_id', 

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
         
        'pre_customer_product_id' => 'integer',
        'product_discount_id' => 'integer', 

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer_product()
    {
        return $this->belongsTo(PreCustomerProduct::class);
    }
 
    public function product_discount()
    {
        return $this->belongsTo(ProductDiscount::class);
    } 
}
