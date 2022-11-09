<?php

namespace Gmedia\IspSystem\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'customer';

    protected $attributes = [
        'money' => 0,
    ];

    protected $fillable = [
        // 'id',
        'cid',
        'name',
        'registration_date',

        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',

        'money',

        'address',
        'latitude',
        'longitude',
        'npwp',

        'previous_isp_id',
        'previous_isp_price',
        'previous_isp_bandwidth',
        'previous_isp_feature',
        'previous_isp_bandwidth_unit_id',

        'branch_id',

        'created_at',
        'updated_at',

        'user_id',

        'previous_isp_bandwidth_type_id',

        'identity_card',
        'postal_code',
        'fax',

        'uuid',

        'alias_name',
        'identity_card_file',
        'house_photo',

        'device_token',

        'is_isp',

        'brand_id',
        'category_id',
        'memo',

        'contact_person',

        'service',
        'billing',
        'subsidy',
        'active',
        'tax',

        'json_products',
        'json_agents',

        'invoice_increment',

        'public_facility',
        'price_include_tax',

        'json_product_tags',
        'installation_address',
        'json_phone_numbers',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'cid' => 'string',
        'name' => 'string',
        'registration_date' => 'date:Y-m-d',

        'province_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',

        'money' => 'integer',

        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'npwp' => 'string',

        'previous_isp_id' => 'integer',
        'previous_isp_price' => 'integer',
        'previous_isp_bandwidth' => 'integer',
        'previous_isp_feature' => 'string',
        'previous_isp_bandwidth_unit_id' => 'integer',

        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'user_id' => 'integer',

        'previous_isp_bandwidth_type_id' => 'integer',

        'identity_card' => 'string',
        'postal_code' => 'string',
        'fax' => 'string',

        'uuid' => 'string',

        'alias_name' => 'string',
        'identity_card_file' => 'string',
        'house_photo' => 'string',

        'device_token' => 'string',

        'is_isp' => 'boolean',

        'brand_id' => 'integer',
        'category_id' => 'integer',
        'memo' => 'integer',

        'contact_person' => 'string',

        'service' => 'boolean',
        'billing' => 'boolean',
        'subsidy' => 'boolean',
        'active' => 'boolean',
        'tax' => 'boolean',

        'json_products' => 'string',
        'json_agents' => 'string',

        'invoice_increment' => 'integer',

        'public_facility' => 'boolean',
        'price_include_tax' => 'boolean',

        'json_product_tags' => 'string',
        'installation_address' => 'string',
        'json_phone_numbers' => 'string',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function previous_isp_bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }

    public function emails()
    {
        return $this->hasMany(CustomerEmail::class);
    }

    public function phone_numbers()
    {
        return $this->hasMany(CustomerPhoneNumber::class);
    }

    public function customer_products()
    {
        return $this->hasMany(CustomerProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, CustomerProduct::class)->withPivot('id');
    }

    public function invoice_scheme_pays()
    {
        return $this->hasMany(ArInvoiceScheme::class, 'payer');
    }

    public function invoice_scheme_customers()
    {
        return $this->hasMany(ArInvoiceSchemeCustomer::class);
    }

    public function invoice_pays()
    {
        return $this->hasMany(ArInvoice::class, 'payer');
    }

    public function invoice_customers()
    {
        return $this->hasMany(ArInvoiceCustomer::class);
    }

    public function logs()
    {
        return $this->hasMany(CustomerLog::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function category()
    {
        return $this->belongsTo(CustomerCategory::class);
    }

    public function memo_ref()
    {
        return $this->belongsTo(Branch::class, 'memo');
    }
}
