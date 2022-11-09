<?php

namespace Gmedia\IspSystem\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PreCustomerRequest extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'pre_customer_request';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'email',
        'phone_number',
        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',
        'address',
        'know_from_id',
        'need_id',
        'need_description',
        'device_token',
        'user_id',
        'submit_by',
        'submit_at',
        'sent_to_sales_at',
        'followed_up_by',
        'followed_up_at',
        'branch_id',

        'created_at',
        'updated_at',

        'latitude',
        'longitude',

        'sent_to_sales_by',
        'brand_id',

        'message_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'name' => 'string',
        'email' => 'string',
        'phone_number' => 'string',
        'province_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',
        'address' => 'string',
        'know_from_id' => 'integer',
        'need_id' => 'integer',
        'need_description' => 'string',
        'device_token' => 'string',
        'user_id' => 'integer',
        'submit_by' => 'integer',
        'submit_at' => 'datetime',
        'sent_to_sales_at' => 'datetime',
        'followed_up_by' => 'integer',
        'followed_up_at' => 'datetime',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'latitude' => 'double',
        'longitude' => 'double',

        'sent_to_sales_by' => 'integer',
        'brand_id' => 'integer',

        'message_id' => 'string',
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

    public function know_from()
    {
        return $this->belongsTo(PreCustomerRequestKnowFrom::class);
    }

    public function need()
    {
        return $this->belongsTo(PreCustomerRequestNeed::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submit_by_ref()
    {
        return $this->belongsTo(Employee::class, 'submit_by');
    }

    public function followed_up_by_ref()
    {
        return $this->belongsTo(Employee::class, 'followed_up_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function logs()
    {
        return $this->hasMany(PreCustomerRequestLog::class);
    }

    public function sent_to_sales_by_ref()
    {
        return $this->belongsTo(Employee::class, 'sent_to_sales_by');
    }
}
