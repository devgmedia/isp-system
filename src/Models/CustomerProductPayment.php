<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProductPayment extends Pivot
{
    public $incrementing = true;
    protected $connection = 'isp_system';
    protected $table = 'customer_product_payment';

    protected $attributes = [];

    protected $fillable = [
        // 'id',

        'customer_product_id',
        'product_billing_id',

        'cash_bank_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        
        'customer_product_id' => 'integer',
        'product_billing_id' => 'integer',

        'cash_bank_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function product_billing()
    {
        return $this->belongsTo(ProductBilling::class);
    }

    public function cash_bank()
    {
        return $this->belongsTo(CashBank::class);
    }
}
