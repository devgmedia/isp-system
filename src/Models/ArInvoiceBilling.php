<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceBilling extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'ar_invoice_billing';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',
        'cash_bank_id',

        'bank_name',
        'bank_branch',
        'on_behalf_of',
        'number',

        'created_at',
        'updated_at',

        'customer_product_payment_id',
        'is_virtual_account',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'integer',
        'cash_bank_id' => 'integer',

        'bank_name' => 'string',
        'bank_branch' => 'string',
        'on_behalf_of' => 'string',
        'number' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'customer_product_payment_id' => 'integer',
        'is_virtual_account' => 'boolean',
    ];

    public function invoice()
    {
        return $this->belongsTo(ArInvoice::class, 'ar_invoice_id');
    }

    public function cash_bank()
    {
        return $this->belongsTo(CashBank::class);
    }

    public function customer_product_payment()
    {
        return $this->belongsTo(CustomerProductPayment::class);
    }
}
