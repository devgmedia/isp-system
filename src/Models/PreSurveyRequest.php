<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreSurveyRequest extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_survey_request';

    protected $fillable = [
        // 'id',
        'uuid',
        'pre_customer_prospective_id',
        'pre_customer_id',
        'request_by',
        'request_date',
        'request_name',
        'branch_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'pre_customer_prospective_id' => 'integer',
        'pre_customer_id' => 'integer',
        'request_by' => 'integer',
        'request_date' => 'date',
        'request_name' => 'string',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
    }
}
