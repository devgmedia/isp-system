<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerProspective extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_prospective';

    protected $fillable = [
        'id',
        'uuid',
        'pre_customer_id',
        'prospective_by',
        'prospective_date',
        'prospective_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'pre_customer_id' => 'integer',
        'prospective_by' => 'string',
        'prospective_date' => 'date',
        'prospective_name' => 'string',
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

    public function logs()
    {
        return $this->hasMany(PreCustomerLog::class);
    }

    public function pre_survey_request()
    {
        return $this->belongsTo(PreSurveyRequest::class, 'id', 'pre_customer_id');
    }
}
