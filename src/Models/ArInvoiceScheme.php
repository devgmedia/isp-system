<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceScheme extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_scheme';

    protected $attributes = [
        'name' => null,

        'ignore_tax' => false,
        'ignore_prorated' => false,
        'postpaid' => false,
        'hybrid' => false,
    ];

    protected $fillable = [
        // 'id',
        'payer',
        'payment_scheme_id',

        'created_at',
        'updated_at',

        'name',

        'ignore_tax',
        'ignore_prorated',

        'postpaid',
        'hybrid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'payer' => 'integer',
        'payment_scheme_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'name' => 'string',

        'ignore_tax' => 'boolean',
        'ignore_prorated' => 'boolean',

        'postpaid' => 'boolean',
        'hybrid' => 'boolean',
    ];

    public function payer_ref()
    {
        return $this->belongsTo(Customer::class, 'payer');
    }

    public function payment_scheme()
    {
        return $this->belongsTo(PaymentScheme::class);
    }

    public function scheme_customers()
    {
        return $this->hasMany(ArInvoiceSchemeCustomer::class);
    }

    public function invoices()
    {
        return $this->hasMany(ArInvoice::class);
    }
}
