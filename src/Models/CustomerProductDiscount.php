<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProductDiscount extends Pivot
{
    public $incrementing = true;
    protected $connection = 'isp_system';
    protected $table = 'customer_product_discount';

    protected $attributes = [];

    protected $fillable = [
        // 'id',

        'customer_product_id',
        'product_discount_id',

        'start_date',
        'end_date',

        'created_at',
        'updated_at',
        
        'discount_name',
        'discount_price',
        'discount_price_usd',
        'discount_price_sgd',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        
        'customer_product_id' => 'integer',
        'product_discount_id' => 'integer',
        
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        
        'discount_name' => 'string',
        'discount_price' => 'integer',
        'discount_price_usd' => 'integer',
        'discount_price_sgd' => 'integer',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function product_discount()
    {
        return $this->belongsTo(ProductDiscount::class);
    }

    public function invoice_customer_product_discounts()
    {
        return $this->hasMany(ArInvoiceCustomerProductDiscount::class, 'customer_product_discount_id');
    }
}
