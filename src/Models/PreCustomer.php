<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomer extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'pre_customer';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',

        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',

        'address',
        'latitude',
        'longitude',
        'npwp',

        'previous_isp_id',
        'previous_isp_price',
        'previous_isp_bandwidth',
        'previous_isp_feature',
        'previous_isp_bandwidth_unit_id',
        'previous_isp_bandwidth_type_id',

        'branch_id',

        'identity_card',
        'postal_code',
        'fax',

        'created_at',
        'updated_at',

        'alias_name',

        'add_to_existing_customer',
        'add_to_existing_customer_id',
        'identity_card_file',
        'house_photo',
        'customer_category_id',

        'cid',
        'user_id',

        'device_token',

        'is_isp',
        'brand_id',
        'contact_person',

        'json_products',
        'json_agents',

        'public_facility',

        'price_include_tax',
        'json_product_tags',

        'installation_address',
        'signature_covered',
        'signature_installation',

        'verification_attempt',
        'verification_contact',
        'verification_contact_sent',

        'code_verification',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'province_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'npwp' => 'string',

        'previous_isp_id' => 'integer',
        'previous_isp_price' => 'integer',
        'previous_isp_bandwidth' => 'integer',
        'previous_isp_feature' => 'string',
        'previous_isp_bandwidth_unit_id' => 'integer',
        'previous_isp_bandwidth_type_id' => 'integer',

        'branch_id' => 'integer',

        'identity_card' => 'string',
        'postal_code' => 'string',
        'fax' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'alias_name' => 'string',

        'add_to_existing_customer' => 'boolean',
        'add_to_existing_customer_id' => 'integer',
        'identity_card_file' => 'string',
        'house_photo' => 'string',
        'customer_category_id' => 'integer',

        'cid' => 'string',
        'user_id' => 'integer',

        'device_token' => 'string',

        'is_isp' => 'boolean',
        'brand_id' => 'integer',
        'contact_person' => 'string',

        'json_products' => 'string',
        'json_agents' => 'string',

        'public_facility' => 'boolean',

        'price_include_tax' => 'boolean',
        'json_product_tags' => 'string',

        'installation_address' => 'string',
        'signature_covered' => 'string',
        'signature_installation' => 'string',

        'verification_attempt' => 'integer',
        'verification_contact' => 'integer',
        'verification_contact_sent' => 'integer',

        'code_verification' => 'string',
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

    public function previous_isp_bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emails()
    {
        return $this->hasMany(PreCustomerEmail::class);
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
        return $this->belongsToMany(Product::class, PreCustomerProduct::class)->withPivot('id');
    }

    public function logs()
    {
        return $this->hasMany(PreCustomerLog::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function category()
    {
        return $this->belongsTo(CustomerCategory::class);
    }

    public function pre_customer_prospective()
    {
        return $this->belongsTo(PreCustomerProspective::class, 'id', 'pre_customer_id');
    }

    public function pre_survey_request()
    {
        return $this->belongsTo(PreSurveyRequest::class, 'id', 'pre_customer_id');
    }

    public function pre_survey_reporting()
    {
        return $this->belongsTo(PreSurveyReporting::class, 'id', 'pre_customer_id');
    }

    public function survey_request()
    {
        return $this->belongsTo(SurveyRequest::class, 'id', 'pre_customer_id');
    }

    public function survey_reporting()
    {
        return $this->belongsTo(SurveyReporting::class, 'id', 'pre_customer_id');
    }

    public function installation_request()
    {
        return $this->belongsTo(InstallationRequest::class, 'id', 'pre_customer_id');
    }

    public function installation_reporting()
    {
        return $this->belongsTo(InstallationReporting::class, 'id', 'pre_customer_id');
    }
}
