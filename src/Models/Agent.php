<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = 'agent';

    protected $attributes = [
        'money' => 0,
    ];

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'alias_name',
        'registration_date',
        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',
        'address',
        'postal_code',
        'fax',
        'money',
        'email',
        'identity_card',
        'identity_card_file',
        'npwp',
        'user_id',
        'branch_id',
        'token_device',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'alias_name' => 'string',
        'registration_date' => 'date:Y-m-d',
        'province_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',
        'address' => 'string',
        'postal_code' => 'string',
        'fax' => 'string',
        'money' => 'integer',
        'email' => 'string',
        'identity_card' => 'string',
        'npwp' => 'string',
        'user_id' => 'integer',
        'branch_id' => 'integer',
        'token_device' => 'string',

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function phone_numbers()
    {
        return $this->hasMany(AgentPhoneNumber::class);
    }

    public function cash_withdrawals()
    {
        return $this->hasMany(AgentCashWithdrawal::class);
    }

    public function money_histories()
    {
        return $this->hasMany(AgentMoneyHistory::class);
    }

    public function customer_products()
    {
        return $this->hasMany(CustomerProduct::class);
    }
}
