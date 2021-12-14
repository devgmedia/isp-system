<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProductDiscount extends Pivot
{
    public $incrementing = true;
    protected $table = 'customer_product_discount';

    protected $attributes = [];

    protected $fillable = [
        // 'id',

        'registration_date',
        'customer_product_id',
        'product_discount_id',
        'start_date',
        'end_date',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        
        'registration_date' => 'date:Y-m-d',
        'customer_product_id' => 'integer',
        'product_discount_id' => 'integer',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
