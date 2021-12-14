<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceSchemeCustomer extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_scheme_customer';

    protected $fillable = [
        // 'id',
        'ar_invoice_scheme_id',
        'customer_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_scheme_id' => 'integer',
        'customer_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scheme()
    {
        return $this->belongsTo(ArInvoiceScheme::class, 'ar_invoice_scheme_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scheme_customer_products()
    {
        return $this->hasMany(ArInvoiceSchemeCustomerProduct::class);
    }

    public function scheme_customer_product_additionals()
    {
        return $this->hasMany(ArInvoiceSchemeCustomerProductAdditional::class);
    }

    public function invoice_customers()
    {
        return $this->hasMany(ArInvoiceCustomer::class);
    }
}
