<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProduct extends Pivot
{
    public $incrementing = true;

    protected $connection = 'isp_system';

    protected $table = 'customer_product';

    protected $attributes = [
        // retail internet service
        'auto_sent_invoice_via_email' => false,
        'auto_sent_invoice_via_whatsapp' => false,

        'auto_disable_connection' => false,

        'auto_sent_invoice_reminder_via_email' => false,
        'auto_sent_invoice_reminder_via_whatsapp' => false,

        'ignore_tax' => false,
        'ignore_prorated' => false,
        'postpaid' => false,
        'hybrid' => false,

        // enterprise internet service
        'tax' => true,
    ];

    protected $fillable = [
        // 'id',
        'sid',

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

        'service_date',
        'billing_date',

        'site_address',

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

        'postpaid',

        'adjusted_bandwidth',
        'special_bandwidth',

        'whatsapp_request_issue_sent_at',
        'whatsapp_device_off_confirmation_request_sent_at',

        'email_support_auto_disable_sent_at',

        'whatsapp_start_conversation_sent_at',
        'whatsapp_disable_connection_information_sent_at',

        'referrer',
        'referrer_used_for_discount',

        'tax',
        'ar_invoice_item_category_id',
        'product_name',
        'product_price',
        'product_price_usd',
        'product_price_sgd',

        'enterprise_billing_date',
        'billing_time',
        'billing_cycle',
        'active',
        'qrcode',

        'ar_invoice_faktur_id',

        'receiver_name',
        'receiver_address',
        'receiver_phone_number',
        'receiver_email',

        'uuid',

        'receiver_attention',
        'site_pic',

        'hybrid',
        'installation_invoice_whatsapp_at',
        'installation_invoice_email_at',
        'installation_invoice_due_date',
        'installation_invoice_paid_at',
        'installation_date',
        'installation_schedule_date',

        'payment_is_active',
        'public_facility',

        'json_product_tags',
        'subsidy',

        'pre_customer_product_id',

        'isolation',
        'isolation_reference',
        'isolation_whatsapp_at',
        'isolation_whatsapp_by',
        'isolation_invoice',

        'billing_request_date',

        'installation_message',
        'installation_schedule_message',
        'installation_report_by',

        'tax_rate',
        'tax_rounding',

        'vendor_id'
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'sid' => 'string',

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

        'service_date' => 'date:Y-m-d',
        'billing_date' => 'date:Y-m-d',

        'site_address' => 'string',

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

        'postpaid' => 'boolean',

        'adjusted_bandwidth' => 'boolean',
        'special_bandwidth' => 'integer',

        'whatsapp_request_issue_sent_at' => 'datetime',
        'whatsapp_device_off_confirmation_request_sent_at' => 'datetime',

        'email_support_auto_disable_sent_at' => 'datetime',

        'whatsapp_start_conversation_sent_at' => 'datetime',
        'whatsapp_disable_connection_information_sent_at' => 'datetime',

        'referrer' => 'integer',
        'referrer_used_for_discount' => 'boolean',

        'tax' => 'boolean',
        'ar_invoice_item_category_id' => 'integer',
        'product_name' => 'string',
        'product_price' => 'integer',
        'product_price_usd' => 'integer',
        'product_price_sgd' => 'integer',

        'enterprise_billing_date' => 'date:Y-m-d',
        'billing_time' => 'integer',
        'billing_cycle' => 'integer',
        'active' => 'boolean',
        'qrcode' => 'boolean',

        'ar_invoice_faktur_id' => 'integer',

        'receiver_name' => 'string',
        'receiver_address' => 'string',
        'receiver_phone_number' => 'string',
        'receiver_email' => 'string',

        'uuid' => 'string',

        'receiver_attention' => 'string',
        'site_pic' => 'string',

        'hybrid' => 'boolean',
        'installation_invoice_whatsapp_at' => 'datetime',
        'installation_invoice_email_at' => 'datetime',
        'installation_invoice_due_date' => 'date:Y-m-d',
        'installation_invoice_paid_at' => 'datetime',
        'installation_date' => 'date:Y-m-d',
        'installation_schedule_date' => 'date:Y-m-d',

        'payment_is_active' => 'boolean',
        'public_facility' => 'boolean',

        'json_product_tags' => 'string',
        'subsidy' => 'boolean',

        'pre_customer_product_id' => 'integer',

        'isolation' => 'boolean',
        'isolation_reference' => 'string',
        'isolation_whatsapp_at' => 'datetime',
        'isolation_whatsapp_by' => 'integer',
        'isolation_invoice' => 'integer',

        'billing_request_date' => 'date:Y-m-d',

        'installation_message' => 'string',
        'installation_schedule_message' => 'string',
        'installation_report_by' => 'integer',

        'tax_rate' => 'integer',
        'tax_rounding' => 'string',

        'vendor_id' => 'integer'
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

    public function sales_ref()
    {
        return $this->belongsTo(Employee::class, 'sales');
    }

    public function logs()
    {
        return $this->hasMany(CustomerProductLog::class, 'customer_product_id');
    }

    public function referrer_ref()
    {
        return $this->belongsTo(Customer::class, 'referrer');
    }

    public function ar_invoice_item_category()
    {
        return $this->belongsTo(ArInvoiceItemCategory::class);
    }

    public function ar_invoice_faktur()
    {
        return $this->belongsTo(ArInvoiceFaktur::class);
    }

    public function customer_product_payments()
    {
        return $this->hasMany(CustomerProductPayment::class, 'customer_product_id');
    }

    public function payments()
    {
        return $this->belongsToMany(CashBank::class, CustomerProductPayment::class, 'customer_product_id', 'cash_bank_id')->withPivot('id');
    }

    public function pre_customer_product()
    {
        return $this->belongsTo(PreCustomerProduct::class);
    }

    public function isolation_whatsapp_by_ref()
    {
        return $this->belongsTo(Employee::class, 'isolation_whatsapp_by');
    }

    public function isolation_invoice_ref()
    {
        return $this->belongsTo(ArInvoice::class, 'isolation_invoice');
    }

    public function installation_report_by_ref()
    {
        return $this->belongsTo(Employee::class, 'installation_report_by');
    }

    public function customer_product_installation_photos()
    {
        return $this->hasMany(CustomerProductInstallationPhoto::class);
    }

    public function customer_product_installation_assignees()
    {
        return $this->hasMany(CustomerProductInstallationAssignee::class, 'customer_product_id');
    }

    public function customer_product_installation_item()
    {
        return $this->hasMany(CustomerProductInstallationItem::class, 'customer_product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Supplier::class, 'vendor_id');
    }
}
