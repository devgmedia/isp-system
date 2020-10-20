<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoice extends Model
{
    protected $table = 'ar_invoice';

    protected $attributes = [
        'discount' => 0,
        'dpp' => 0,
        'ppn' => 0,
        'total' => 0,
        'paid' => false,

        'price' => 0,

        'email_sent' => false,

        'previous_price' => 0,
        'previous_discount' => 0,
        'previous_ppn' => 0,
        'previous_dpp' => 0,
        'previous_total' => 0,
        'previous_paid' => false,

        'paid_at' => null,
        'email_sent_at' => null,
        'payment_date' => null,

        'billing_date' => null,

        'remaining_payment' => 0,
        'previous_remaining_payment' => 0,
        'paid_total' => 0,
    ];

    protected $fillable = [
        // 'id',
        'ar_invoice_scheme_id',
        'number',
        'date',
        'due_date',
        'discount',
        'dpp',
        'ppn',
        'total',
        'paid',
        'payer',
        'payer_cid',
        'payer_name',
        'payer_province_id',
        'payer_province_name',
        'payer_district_id',
        'payer_district_name',
        'payer_sub_district_id',
        'payer_sub_district_name',
        'payer_village_id',
        'payer_village_name',
        'payer_address',
        
        'created_at',
        'updated_at',

        'branch_id',
        'price',
        'proof_of_payment',

        'created_at',
        'updated_at',

        'email_sent',

        'payer_postal_code',
        'payer_phone_number',
        'payer_fax',
        'payer_email',

        'brand_id',
        'brand_name',

        'receiver_name',
        'receiver_address',
        'receiver_postal_code',
        'receiver_phone_number',
        'receiver_fax',
        'receiver_email',

        'previous',
        'previous_price',
        'previous_discount',
        'previous_ppn',
        'previous_dpp',
        'previous_total',
        'previous_paid',

        'name',

        'paid_at',
        'email_sent_at',
        'payment_date',

        'billing_date',

        'paid_via_midtrans',

        'remaining_payment',
        'previous_remaining_payment',
        'paid_total',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_scheme_id' => 'integer',
        'number' => 'string',
        'date' => 'date:Y-m-d',
        'due_date' => 'date:Y-m-d',
        'discount' => 'double',
        'dpp' => 'double',
        'ppn' => 'double',
        'total' => 'double',
        'paid' => 'boolean',
        'payer' => 'integer',
        'payer_cid' => 'string',
        'payer_name' => 'string',
        'payer_province_id' => 'integer',
        'payer_province_name' => 'string',
        'payer_district_id' => 'integer',
        'payer_district_name' => 'string',
        'payer_sub_district_id' => 'integer',
        'payer_sub_district_name' => 'string',
        'payer_village_id' => 'integer',
        'payer_village_name' => 'string',
        'payer_address' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'branch_id' => 'integer',

        'price' => 'double',
        'proof_of_payment' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'email_sent' => 'boolean',

        'payer_postal_code' => 'string',
        'payer_phone_number' => 'string',
        'payer_fax' => 'string',
        'payer_email' => 'string',

        'brand_id' => 'integer',
        'brand_name' => 'string',

        'receiver_name' => 'string',
        'receiver_address' => 'string',
        'receiver_postal_code' => 'string',
        'receiver_phone_number' => 'string',
        'receiver_fax' => 'string',
        'receiver_email' => 'string',

        'previous' => 'integer',
        'previous_price' => 'double',
        'previous_discount' => 'double',
        'previous_ppn' => 'double',
        'previous_dpp' => 'double',
        'previous_total' => 'double',
        'previous_paid' => 'boolean',

        'name' => 'string',

        'paid_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'payment_date' => 'date',

        'billing_date' => 'date',

        'paid_via_midtrans' => 'boolean',

        'remaining_payment' => 'double',
        'previous_remaining_payment' => 'double',
        'paid_total' => 'double',
    ];

    public function scheme()
    {
        return $this->belongsTo(ArInvoiceScheme::class, 'ar_invoice_scheme_id');
    }

    public function payer_ref()
    {
        return $this->belongsTo(Customer::class, 'payer');
    }

    public function payer_province()
    {
        return $this->belongsTo(Province::class);
    }

    public function payer_district()
    {
        return $this->belongsTo(District::class);
    }

    public function payer_sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function payer_village()
    {
        return $this->belongsTo(Village::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function previous()
    {
        return $this->belongsTo(ArInvoice::class, 'previous');
    }

    public function next()
    {
        return $this->hasOne(ArInvoice::class, 'previous');
    }

    public function invoice_customers()
    {
        return $this->hasMany(ArInvoiceCustomer::class);
    }
}
