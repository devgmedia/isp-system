<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceCustomerProductDiscount extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'ar_invoice_customer_product_discount';

    protected $fillable = [
        // 'id',
        'ar_invoice_customer_product_id',
        'customer_product_discount_id',

        'created_at',
        'updated_at',

        'customer_product_discount_name',

        'total',
        'total_usd',
        'total_sgd',

        'discount_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_customer_product_id' => 'integer',
        'customer_product_discount_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'customer_product_discount_name' => 'string',

        'total' => 'double',
        'total_usd' => 'double',
        'total_sgd' => 'double',

        'discount_name' => 'string',
    ];

    public function invoice_customer_product()
    {
        return $this->belongsTo(ArInvoiceCustomerProduct::class, 'ar_invoice_customer_product_id');
    }

    public function customer_product_discount()
    {
        return $this->belongsTo(CustomerProductDiscount::class);
    }
}
