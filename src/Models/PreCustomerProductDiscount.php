<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PreCustomerProductDiscount extends Pivot
{
    public $incrementing = true;
    protected $table = 'pre_customer_product_discount';

    protected $attributes = [
        'corrected' => false,
    ];

    protected $fillable = [
        // 'id',

        'registration_date',
        'pre_customer_product_id',
        'product_discount_id',
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
        'pre_customer_product_id' => 'integer',
        'product_discount_id' => 'integer',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'corrected' => 'boolean',
    ];

    public function pre_customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function product_discount()
    {
        return $this->belongsTo(ProductDiscount::class);
    }

    public function invoice_customer_product_discounts()
    {
        return $this->hasMany(ArInvoiceCustomerProductDiscount::class, 'pre_customer_product_discount_id');
    }
}
