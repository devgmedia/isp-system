<?php

namespace Gmedia\IspSystem\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $connection = 'isp_system';

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

        'device_token',

        'created_at',
        'updated_at',

        'whatsapp_start_conversation_sent_at',
        'whatsapp_fee_confirmation_sent_at',

        'bank_account_book',
        'brand_id',
        'active',
        'area_id',
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

        'device_token' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'whatsapp_start_conversation_sent_at' => 'datetime',
        'whatsapp_fee_confirmation_sent_at' => 'datetime',

        'bank_account_book' => 'string',
        'brand_id' => 'integer',
        'active' => 'boolean',
        'area_id' => 'integer',
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

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function area()
    {
        return $this->belongsTo(AgentArea::class);
    }

    public function phone_numbers()
    {
        return $this->hasMany(AgentPhoneNumber::class);
    }

    public function cash_withdrawals()
    {
        return $this->hasMany(AgentCashWithdrawal::class);
    }

    public function bank_accounts()
    {
        return $this->hasMany(AgentBankAccount::class);
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
