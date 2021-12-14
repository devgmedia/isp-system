<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceCustomer extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_customer';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',
        'customer_id',

        'created_at',
        'updated_at',
        
        'ar_invoice_scheme_customer_id',
        'customer_cid',
        'customer_name',
        'customer_province_id',
        'customer_province_name',
        'customer_district_id',
        'customer_district_name',
        'customer_sub_district_id',
        'customer_sub_district_name',
        'customer_village_id',
        'customer_village_name',
        'customer_address',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'integer',
        'customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'ar_invoice_scheme_customer_id' =>  'integer',
        'customer_cid' => 'string',
        'customer_name' => 'string',
        'customer_province_id' => 'integer',
        'customer_province_name' => 'string',
        'customer_district_id' => 'integer',
        'customer_district_name' => 'string',
        'customer_sub_district_id' => 'integer',
        'customer_sub_district_name' => 'string',
        'customer_village_id' => 'integer',
        'customer_village_name' => 'string',
        'customer_address' => 'string',
    ];

    public function invoice()
    {
        return $this->belongsTo(ArInvoice::class, 'ar_invoice_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scheme_customer()
    {
        return $this->belongsTo(ArInvoiceSchemeCustomer::class, 'ar_invoice_scheme_customer_id');
    }

    public function customer_province()
    {
        return $this->belongsTo(Province::class);
    }

    public function customer_district()
    {
        return $this->belongsTo(District::class);
    }

    public function customer_sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function customer_village()
    {
        return $this->belongsTo(Village::class);
    }

    public function invoice_customer_products()
    {
        return $this->hasMany(ArInvoiceCustomerProduct::class);
    }

    public function invoice_customer_product_additionals()
    {
        return $this->hasMany(ArInvoiceCustomerProductAdditional::class);
    }
}
