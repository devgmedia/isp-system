<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductInstallationReport extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'customer_product_installation_report';

    protected $fillable = [
        // 'id',
        'uuid',
        'customer_product_id',
        'service',
        'circuit_id',
        'add_on',
        'onu_ont_type',
        'ip_gateway',
        'power_on_odp',
        'power_on_onu',
        'server',
        'speed_upload',
        'speed_download',
        'signature_technical',
        'signature_customer',
        'distribution_olt',
        'distribution_odp',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid'=> 'string',
        'customer_product_id'=> 'integer',
        'service'=> 'string',
        'circuit_id'=> 'string',
        'add_on'=> 'string',
        'onu_ont_type'=> 'string',
        'ip_gateway'=> 'string',
        'power_on_odp'=> 'string',
        'power_on_onu'=> 'string',
        'server'=> 'string',
        'speed_upload'=> 'string',
        'speed_download'=> 'string',
        'signature_technical'=> 'string',
        'signature_customer'=> 'string',
        'distribution_olt'=> 'string',
        'distribution_odp'=> 'string'
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
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
