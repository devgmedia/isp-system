<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use  GMedia\IspSystem\Models\Province;
use  GMedia\IspSystem\Models\District;
use  GMedia\IspSystem\Models\SubDistrict;
use  GMedia\IspSystem\Models\Village;
use  GMedia\IspSystem\Models\Isp;
use  GMedia\IspSystem\Models\BandwidthUnit;
use  GMedia\IspSystem\Models\Branch;
use  GMedia\IspSystem\Models\BandwidthType;
use  GMedia\IspSystem\Models\PreCustomerAlternativeEmail;
use  GMedia\IspSystem\Models\PreCustomerPhoneNumber;
use  GMedia\IspSystem\Models\ArInvoiceSchemeCustomer;
use  GMedia\IspSystem\Models\ArInvoice;
use  GMedia\IspSystem\Models\ArInvoiceCustomer;
use  GMedia\IspSystem\Models\User;

class PreCustomer extends Model
{
    protected $table = 'pre_customer';

    protected $fillable = [
        // 'id',
        'name',
        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',
        'address',
        'latitude',
        'longitude',
        'email',
        'npwp',

        'previous_isp_id',
        'previous_isp_price',
        'previous_isp_bandwidth',
        'previous_isp_feature',
        'previous_isp_bandwidth_unit_id',
        'previous_isp_bandwidth_type_id',
        
        'branch_id',

        'created_at',
        'updated_at',
        
        'identity_card',

        'postal_code',
        'fax',

        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'province_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'email' => 'string',
        'npwp' => 'string',

        'previous_isp_id' => 'integer',
        'previous_isp_price' => 'integer',
        'previous_isp_bandwidth' => 'integer',
        'previous_isp_feature' => 'string',
        'previous_isp_bandwidth_unit_id' => 'integer',
        'previous_isp_bandwidth_type_id' => 'integer',
        
        'branch_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'identity_card' => 'string',

        'postal_code' => 'string',
        'fax' => 'string',

        'uuid' => 'string',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function previous_isp()
    {
        return $this->belongsTo(Isp::class);
    }

    public function previous_isp_bandwidth_unit()
    {
        return $this->belongsTo(BandwidthUnit::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function previous_isp_bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }

    public function alternative_emails()
    {
        return $this->hasMany(PreCustomerAlternativeEmail::class);
    }

    public function phone_numbers()
    {
        return $this->hasMany(PreCustomerPhoneNumber::class);
    }

    public function pre_customer_products()
    {
        return $this->hasMany(PreCustomerProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, CustomerProduct::class)->withPivot('id');
    }

    public function invoice_scheme_customers()
    {
        return $this->hasMany(ArInvoiceSchemeCustomer::class);
    }

    public function invoice_customers()
    {
        return $this->hasMany(ArInvoiceCustomer::class);
    }

    public function invoice_pays()
    {
        return $this->hasMany(ArInvoice::class, 'payer');
    }
}
