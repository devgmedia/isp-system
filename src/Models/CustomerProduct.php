<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProduct extends Pivot
{
    public $incrementing = true;
    protected $table = 'customer_product';

    protected $attributes = [
        'first_month_not_billed' => false,

        'auto_sent_invoice_via_email' => false,
        'auto_sent_invoice_via_whatsapp' => false,

        'auto_disable_connection' => false,

        'auto_sent_invoice_reminder_via_email' => false,
        'auto_sent_invoice_reminder_via_whatsapp' => false,

        'ignore_tax' => false,
        'ignore_prorated' => false,
        'postpaid' => false,

        'msd' => false,
    ];

    protected $fillable = [
        // 'id',
        'sid',
        'registration_date',
        'customer_id',
        'product_id',
        'media_id',
        'media_vendor_id',

        'created_at',
        'updated_at',

        'service_end_date',
        'service_start_date',
        'billing_start_date',
        'billing_end_date',

        'dependency', // deprecated
        'first_month_not_billed', // deprecated

        'service_date',
        'billing_date',

        'site_province_id',
        'site_district_id',
        'site_sub_district_id',
        'site_village_id',
        'site_address',
        'site_latitude',
        'site_logitude',

        'agent_id',
        'sales',

        'radius_username',
        'radius_password',

        'adjusted_price',
        'special_price',

        'auto_sent_invoice_via_email',
        'auto_sent_invoice_via_whatsapp',

        'auto_disable_connection',

        'auto_sent_invoice_reminder_via_email',
        'auto_sent_invoice_reminder_via_whatsapp',

        'ignore_tax',

        'whatsapp_maintenance_sent_at',
        'whatsapp_activation_sent_at',
        'whatsapp_mass_disruption_sent_at',
        'whatsapp_confirmation_of_mass_disruption_sent_at',

        'email_maintenance_sent_at',
        'email_activation_sent_at',
        'email_mass_disruption_sent_at',
        'email_confirmation_of_mass_disruption_sent_at',

        'ignore_prorated',

        'site_name',
        'site_email',
        'site_phone_number',
        'site_postal_code',

        'pre_customer_id',
        'postpaid',

        'adjusted_bandwidth',
        'special_bandwidth',
        
        'msd', // deprecated

        'whatsapp_request_issue_sent_at',
        'whatsapp_device_off_confirmation_request_sent_at',

        'email_support_auto_disable_sent_at',

        'whatsapp_start_conversation_sent_at',
        'whatsapp_disable_connection_information_sent_at',

        'referrer',
        'referrer_used_for_discount',

        'marketing', // deprecated 
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'sid' => 'string',
        'registration_date' => 'date:Y-m-d',
        'customer_id' => 'integer',
        'product_id' => 'integer',
        'media_id' => 'integer',
        'media_vendor_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'service_end_date' => 'date:Y-m-d',
        'service_start_date' => 'date:Y-m-d',
        'billing_start_date' => 'date:Y-m-d',
        'billing_end_date' => 'date:Y-m-d',

        'dependency' => 'integer',
        'first_month_not_billed' => 'boolean',

        'service_date' => 'date:Y-m-d',
        'billing_date' => 'date:Y-m-d',

        'site_province_id' => 'integer',
        'site_district_id' => 'integer',
        'site_sub_district_id' => 'integer',
        'site_village_id' => 'integer',
        'site_address' => 'string',
        'site_latitude' => 'double',
        'site_logitude' => 'double',

        'agent_id' => 'integer',
        'sales' => 'integer',

        'radius_username' => 'string',
        'radius_password' => 'string',

        'adjusted_price' => 'boolean',
        'special_price' => 'integer',

        'auto_sent_invoice_via_email' => 'boolean',
        'auto_sent_invoice_via_whatsapp' => 'boolean',

        'auto_disable_connection' => 'boolean',

        'auto_sent_invoice_reminder_via_email' => 'boolean',
        'auto_sent_invoice_reminder_via_whatsapp' => 'boolean',

        'ignore_tax' => 'boolean',

        'whatsapp_maintenance_sent_at' => 'datetime',
        'whatsapp_activation_sent_at' => 'datetime',
        'whatsapp_mass_disruption_sent_at' => 'datetime',
        'whatsapp_confirmation_of_mass_disruption_sent_at' => 'datetime',

        'email_maintenance_sent_at' => 'datetime',
        'email_activation_sent_at' => 'datetime',
        'email_mass_disruption_sent_at' => 'datetime',
        'email_confirmation_of_mass_disruption_sent_at' => 'datetime',

        'ignore_prorated' => 'boolean',

        'site_name' => 'string',
        'site_email' => 'string',
        'site_phone_number' => 'string',
        'site_postal_code' => 'string',

        'pre_customer_id' => 'integer',
        'postpaid' => 'boolean',

        'adjusted_bandwidth' => 'boolean',
        'special_bandwidth' => 'integer',

        'msd' => 'boolean',

        'whatsapp_request_issue_sent_at' => 'datetime',
        'whatsapp_device_off_confirmation_request_sent_at' => 'datetime',

        'email_support_auto_disable_sent_at' => 'datetime',

        'whatsapp_start_conversation_sent_at' => 'datetime',
        'whatsapp_disable_connection_information_sent_at' => 'datetime',

        'referrer' => 'integer',
        'referrer_used_for_discount' => 'boolean',

        'marketing' => 'integer',
        'customer_relation' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function media()
    {
        return $this->belongsTo(InternetMedia::class);
    }

    public function media_vendor()
    {
        return $this->belongsTo(InternetMediaVendor::class);
    }

    public function dependency()
    {
        return $this->belongsTo(CustomerProduct::class, 'dependency');
    }

    public function required_by()
    {
        return $this->hasMany(CustomerProduct::class, 'dependency');
    }

    public function customer_product_additionals()
    {
        return $this->hasMany(CustomerProductAdditional::class, 'customer_product_id');
    }

    public function additionals()
    {
        return $this->belongsToMany(ProductAdditional::class, CustomerProductAdditional::class, 'customer_product_id', 'product_additional_id')->withPivot('id');
    }

    public function customer_product_discounts()
    {
        return $this->hasMany(CustomerProductDiscount::class, 'customer_product_id');
    }

    public function discounts()
    {
        return $this->belongsToMany(ProductDiscount::class, CustomerProductDiscount::class, 'customer_product_id', 'product_discount_id')->withPivot('id');
    }

    public function customer_product_isolations()
    {
        return $this->hasMany(CustomerProductIsolation::class, 'customer_product_id');
    }

    public function invoice_scheme_product()
    {
        return $this->hasOne(ArInvoiceSchemeCustomerProduct::class, 'customer_product_id');
    }

    public function invoice_products()
    {
        return $this->hasMany(ArInvoiceCustomerProduct::class, 'customer_product_id');
    }

    public function site_province()
    {
        return $this->belongsTo(Province::class, 'site_province_id');
    }

    public function site_district()
    {
        return $this->belongsTo(District::class, 'site_district_id');
    }

    public function site_sub_district()
    {
        return $this->belongsTo(SubDistrict::class, 'site_sub_district_id');
    }

    public function site_village()
    {
        return $this->belongsTo(Village::class, 'site_village_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
    }

    public function logs()
    {
        return $this->hasMany(CustomerProductLog::class, 'customer_product_id');
    }

    public function referrer_ref()
    {
        return $this->belongsTo(Customer::class, 'referrer');
    }

    public function marketing_ref()
    {
        return $this->belongsTo(Employee::class, 'marketing');
    }
}
