<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceSchemeCustomerProduct extends Model
{
    protected $table = 'ar_invoice_scheme_customer_product';

    protected $fillable = [
        // 'id',
        'ar_invoice_scheme_customer_id',
        'customer_product_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_scheme_customer_id' => 'integer',
        'customer_product_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scheme_customer()
    {
        return $this->belongsTo(ArInvoiceSchemeCustomer::class, 'ar_invoice_scheme_customer_id');
    }

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function scheme_customer_product_additionals()
    {
        return $this->hasMany(ArInvoiceSchemeCustomerProductAdditional::class);
    }

    public function invoice_customer_products()
    {
        return $this->hasMany(ArInvoiceCustomerProduct::class);
    }    
}
