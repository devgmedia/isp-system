<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceSchemeCustomerProductAdditional extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'ar_invoice_scheme_customer_product_additional';

    protected $fillable = [
        // 'id',
        'ar_invoice_scheme_customer_id',
        'ar_invoice_scheme_customer_product_id',
        'customer_product_additional_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_scheme_customer_id' => 'integer',
        'ar_invoice_scheme_customer_additional_id' => 'integer',
        'customer_product_additional_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scheme_customer()
    {
        return $this->belongsTo(ArInvoiceSchemeCustomer::class, 'ar_invoice_scheme_customer_id');
    }

    public function scheme_product()
    {
        return $this->belongsTo(ArInvoiceSchemeCustomerProduct::class, 'ar_invoice_scheme_customer_product_id');
    }

    public function customer_product_additional()
    {
        return $this->belongsTo(CustomerProductAdditional::class);
    }

    public function invoice_customer_product_additionals()
    {
        return $this->hasMany(ArInvoiceCustomerProductAdditional::class);
    }
}
