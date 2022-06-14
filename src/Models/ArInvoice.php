<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoice extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice';

    protected $attributes = [
        'discount' => 0,
        'tax_base' => 0,
        'tax' => 0,
        'total' => 0,
        'paid' => false,

        'price' => 0,

        'email_sent' => false,

        'previous_price' => 0,
        'previous_discount' => 0,
        'previous_tax' => 0,
        'previous_tax_base' => 0,
        'previous_total' => 0,
        'previous_paid' => false,

        'remaining_payment' => 0,
        'previous_remaining_payment' => 0,
        'paid_total' => 0,

        'reminder_email_sent' => false,

        'whatsapp_sent' => false,
        'reminder_whatsapp_sent' => false,

        'created_by_cron' => false,

        'ignore_tax' => false,
        'ignore_prorated' => false,
        'postpaid' => false,
        'hybrid' => false,

        'midtrans_payment_cost' => 0,

        'tax_base_bandwidth' => 0,
        'tax_base_colocation' => 0,
        'tax_base_installation' => 0,
        'tax_base_device' => 0,
        'tax_base_other' => 0,
        'tax_base_application' => 0,

        'tax_base_usd' => 0,
        'tax_base_sgd' => 0,

        'tax_usd' => 0,
        'tax_sgd' => 0,

        'total_usd' => 0,
        'total_sgd' => 0,

        'discount_usd' => 0,
        'discount_sgd' => 0,
        
        'settlement_invoice' => 0,
        'settlement_admin' => 0,
        'settlement_down_payment' => 0,
        'settlement_marketing_fee' => 0,
        'settlement_pph_pasal_22' => 0,
        'settlement_pph_pasal_23' => 0,
        'settlement_ppn' => 0,
    ];

    protected $fillable = [
        // 'id',
        'ar_invoice_scheme_id',
        'number',
        'date',
        'due_date',
        'discount',
        'tax_base',
        'tax',
        'total',
        'paid',
        'payer',
        'payer_cid',
        'payer_name',
        'payer_province_id',
        'payer_province_name',
        'payer_district_id',
        'payer_district_name',
        'payer_sub_district_id',
        'payer_sub_district_name',
        'payer_village_id',
        'payer_village_name',
        'payer_address',
        
        'created_at',
        'updated_at',

        'branch_id',

        'price',
        'proof_of_payment',

        'created_at',
        'updated_at',

        'email_sent',

        'payer_postal_code',
        'payer_phone_number',
        'payer_fax',
        'payer_email',

        'brand_id',
        'brand_name',

        'receiver_name',
        'receiver_address',
        'receiver_postal_code',
        'receiver_phone_number',
        'receiver_fax',
        'receiver_email',

        'previous',
        'previous_price',
        'previous_discount',
        'previous_tax',
        'previous_tax_base',
        'previous_total',
        'previous_paid',

        'name',

        'paid_at',
        'email_sent_at',
        'payment_date',

        'previous_date',

        'billing_date',

        'paid_via_midtrans',

        'uuid',

        'remaining_payment',

        'previous_remaining_payment',
        'paid_total',

        'received_by_agent',
        'received_by_agent_at',
        'reminder_email_sent',
        'reminder_email_sent_at',

        'billing_bank_id',
        'billing_bank_name',
        'billing_bank_account_number',
        'billing_bank_account_on_behalf_of',
        'billing_receiver',
        'billing_receiver_name',

        'available_via_midtrans',

        'whatsapp_sent',
        'whatsapp_sent_at',
        'reminder_whatsapp_sent',
        'reminder_whatsapp_sent_at',
        
        'created_by_cron',
        'ignore_tax',
        'ignore_prorated',

        'receipt_email_sent',
        'receipt_email_sent_at',
        'receipt_whatsapp_sent',
        'receipt_whatsapp_sent_at',

        'postpaid',

        'chart_of_account_title_id',
        
        'product_id',
        'agent_id',
        'billing_end_date',

        'product_name',
        'agent_name',

        'sid',
        'memo',

        'midtrans_payment_type',
        'midtrans_payment_cost',

        'faktur_id',
        'qrcode',

        'tax_base_bandwidth',
        'tax_base_colocation',
        'tax_base_installation',
        'tax_base_device',
        'tax_base_other',
        'tax_base_application',
        
        'period_start_date',
        'period_end_date',
        
        'tax_base_usd',
        'tax_base_sgd',
        
        'tax_usd',
        'tax_sgd',
        
        'total_usd',
        'total_sgd',

        'payer_category_id',
        'memo_to',

        'is_tax',
        'is_edited',
        'is_printed',

        'brand_type_name',
        
        'discount_usd',
        'discount_sgd',

        'billing_npwp_number',
        'billing_npwp_on_behalf_of',
        'billing_phone_number',
        'billing_email',

        'billing_approver',
        'billing_preparer',

        'receiver_attention',
        
        'service',

        'settlement_invoice',
        'settlement_admin',
        'settlement_down_payment',
        'settlement_marketing_fee',
        'settlement_pph_pasal_22',
        'settlement_pph_pasal_23',
        'settlement_ppn',

        'sales',

        'hybrid',
        'public_facility',
        'price_include_tax',
        'json_product_tags',
        'subsidy',

        'reminder_whatsapp_count',

        'tax_rate',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_scheme_id' => 'integer',
        'number' => 'string',
        'date' => 'date:Y-m-d',
        'due_date' => 'date:Y-m-d',
        'discount' => 'double',
        'tax_base' => 'double',
        'tax' => 'double',
        'total' => 'double',
        'paid' => 'boolean',
        'payer' => 'integer',
        'payer_cid' => 'string',
        'payer_name' => 'string',
        'payer_province_id' => 'integer',
        'payer_province_name' => 'string',
        'payer_district_id' => 'integer',
        'payer_district_name' => 'string',
        'payer_sub_district_id' => 'integer',
        'payer_sub_district_name' => 'string',
        'payer_village_id' => 'integer',
        'payer_village_name' => 'string',
        'payer_address' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'branch_id' => 'integer',

        'price' => 'double',
        'proof_of_payment' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'email_sent' => 'boolean',

        'payer_postal_code' => 'string',
        'payer_phone_number' => 'string',
        'payer_fax' => 'string',
        'payer_email' => 'string',

        'brand_id' => 'integer',
        'brand_name' => 'string',

        'receiver_name' => 'string',
        'receiver_address' => 'string',
        'receiver_postal_code' => 'string',
        'receiver_phone_number' => 'string',
        'receiver_fax' => 'string',
        'receiver_email' => 'string',

        'previous' => 'integer',
        'previous_price' => 'double',
        'previous_discount' => 'double',
        'previous_tax' => 'double',
        'previous_tax_base' => 'double',
        'previous_total' => 'double',
        'previous_paid' => 'boolean',

        'name' => 'string',

        'paid_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'payment_date' => 'date:Y-m-d',
        
        'previous_date' => 'date:Y-m-d',

        'billing_date' => 'date:Y-m-d',

        'paid_via_midtrans' => 'boolean',

        'uuid' => 'string',

        'remaining_payment' => 'double',

        'previous_remaining_payment' => 'double',
        'paid_total' => 'double',

        'received_by_agent' => 'boolean',
        'received_by_agent_at' => 'datetime',
        'reminder_email_sent' => 'boolean',
        'reminder_email_sent_at' => 'datetime',

        'billing_bank_id' => 'integer',
        'billing_bank_name' => 'string',
        'billing_bank_account_number' => 'string',
        'billing_bank_account_on_behalf_of' => 'string',
        'billing_receiver' => 'string',
        'billing_receiver_name' => 'string',

        'available_via_midtrans' => 'boolean',

        'whatsapp_sent' => 'boolean',
        'whatsapp_sent_at' => 'datetime',
        'reminder_whatsapp_sent' => 'boolean',
        'reminder_whatsapp_sent_at' => 'datetime',

        'created_by_cron' => 'boolean',
        'ignore_tax' => 'boolean',
        'ignore_prorated' => 'boolean',

        'receipt_email_sent' => 'boolean',
        'receipt_email_sent_at' => 'datetime',
        'receipt_whatsapp_sent' => 'boolean',
        'receipt_whatsapp_sent_at' => 'datetime',

        'postpaid' => 'boolean',

        'chart_of_account_title_id' => 'integer',
        
        'product_id' => 'integer',
        'agent_id' => 'integer',
        'billing_end_date' => 'date:Y-m-d',

        'product_name' => 'string',
        'agent_name' => 'string',

        'sid' => 'string',
        'memo' => 'boolean',

        'midtrans_payment_type' => 'string',
        'midtrans_payment_cost' => 'double',

        'faktur_id' => 'integer',
        'qrcode' => 'boolean',

        'tax_base_bandwidth' => 'double',
        'tax_base_colocation' => 'double',
        'tax_base_installation' => 'double',
        'tax_base_device' => 'double',
        'tax_base_other' => 'double',
        'tax_base_application' => 'double',

        'period_start_date' => 'date:Y-m-d',
        'period_end_date' => 'date:Y-m-d',
        
        'tax_base_usd' => 'double',
        'tax_base_sgd' => 'double',
        
        'tax_usd' => 'double',
        'tax_sgd' => 'double',
        
        'total_usd' => 'double',
        'total_sgd' => 'double',   

        'payer_category_id' => 'integer',
        'memo_to' => 'integer',

        'is_tax' => 'boolean',
        'is_edited' => 'boolean',
        'is_printed' => 'boolean',     

        'brand_type_name' => 'string',

        'discount_usd' => 'double',
        'discount_sgd' => 'double',

        'billing_npwp_number' => 'string',
        'billing_npwp_on_behalf_of' => 'string',
        'billing_phone_number' => 'string',
        'billing_email' => 'string',

        'billing_approver' => 'string',
        'billing_preparer' => 'string',

        'receiver_attention' => 'string',
        
        'service' => 'integer',

        'settlement_invoice' => 'double',
        'settlement_admin' => 'double',
        'settlement_down_payment' => 'double',
        'settlement_marketing_fee' => 'double',
        'settlement_pph_pasal_22' => 'double',
        'settlement_pph_pasal_23' => 'double',
        'settlement_ppn' => 'double',

        'sales' => 'integer',

        'hybrid' => 'boolean',
        'public_facility' => 'boolean',
        'price_include_tax' => 'boolean',
        'json_product_tags' => 'string',
        'subsidy' => 'boolean',

        'reminder_whatsapp_count' => 'integer',

        'tax_rate' => 'integer',
    ];

    public function scheme()
    {
        return $this->belongsTo(ArInvoiceScheme::class, 'ar_invoice_scheme_id');
    }

    public function payer_ref()
    {
        return $this->belongsTo(Customer::class, 'payer');
    }

    public function payer_province()
    {
        return $this->belongsTo(Province::class);
    }

    public function payer_district()
    {
        return $this->belongsTo(District::class);
    }

    public function payer_sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function payer_village()
    {
        return $this->belongsTo(Village::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function previous()
    {
        return $this->belongsTo(ArInvoice::class, 'previous');
    }

    public function next()
    {
        return $this->hasOne(ArInvoice::class, 'previous');
    }

    public function invoice_customers()
    {
        return $this->hasMany(ArInvoiceCustomer::class);
    }

    public function invoice_billings()
    {
        return $this->hasMany(ArInvoiceBilling::class);
    }

    public function billing_bank()
    {
        return $this->belongsTo(Bank::class, 'billing_bank_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function faktur()
    {
        return $this->belongsTo(ArInvoiceFaktur::class);
    }

    public function payer_category()
    {
        return $this->belongsTo(CustomerCategory::class);
    }

    public function memo_to_ref()
    {
        return $this->belongsTo(Branch::class, 'memo_to');
    }

    public function service_ref()
    {
        return $this->belongsTo(CustomerProduct::class, 'service');
    }

    public function sales_ref()
    {
        return $this->belongsTo(Employee::class, 'sales');
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function settlements()
    {
        return $this->hasMany(ArInvoiceSettlement::class);
    }

    public function midtrans()
    {
        return $this->hasMany(ArInvoiceMidtrans::class);
    }

    public function vabcas()
    {
        return $this->hasMany(ArInvoiceVabca::class);
    }

    public function whatsapps()
    {
        return $this->hasMany(ArInvoiceWhatsapp::class);
    }

    public function whatsapp_receipts()
    {
        return $this->hasMany(ArInvoiceWhatsappReceipt::class);
    }

    public function whatsapp_reminders()
    {
        return $this->hasMany(ArInvoiceWhatsappReminder::class);
    }

    public function logs()
    {
        return $this->hasMany(ArInvoiceLog::class);
    }

    public function journal()
    {
        return $this->hasOne(Journal::class);
    }

    public function journal_ar_invoices()
    {
        return $this->hasMany(JournalArInvoice::class);
    }

    public function journal_items()
    {
        return $this->belongsToMany(JournalItem::class, JournalArInvoice::class)->withPivot('id');
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, JournalArInvoice::class)->withPivot('id');
    }
}
