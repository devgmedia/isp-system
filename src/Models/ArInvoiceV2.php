<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\Uuid;
use App\Traits\Signature;

class ArInvoiceV2 extends Model
{
    protected $connection = 'isp_system';
    use SoftDeletes, Uuid, Signature;

    protected $table = 'ar_invoice_v2';

    // ! brand type descriptions
    // 1 Gmedia
    // 2 MSD
    // 3 MSA

    // ! type descriptions
    // 1 Standard
    // 2 Simple

    protected $fillable = [
        'uuid',
        'customer_id',
        'number',

        'date',
        'due_date',
        'billing_start_date',
        'billing_end_date',

        'discount',
        'tax_base',
        'tax',
        'grand_total',

        'payer_cid',
        'payer_name',
        'payer_address',
        'payer_email',
        'payer_postal_code',
        'payer_phone_number',
        'payer_fax',

        'payer_province_id',
        'payer_province_name',
        'payer_district_id',
        'payer_district_name',
        'payer_sub_district_id',
        'payer_sub_district_name',
        'payer_village_id',
        'payer_village_name',

        'brand_id',
        'brand_name',
        'branch_id',

        'receiver_name',
        'receiver_address',
        'receiver_postal_code',
        'receiver_phone_number',
        'receiver_fax',
        'receiver_email',

        'proof_of_payment',

        'email_sent_at',

        'billing_bank_id',
        'billing_bank_name',
        'billing_bank_account_number',
        'billing_bank_account_on_behalf_of',
        'billing_receiver',
        'billing_receiver_name',

        'available_via_midtrans',
        'paid_via_midtrans',

        'received_by_agent',
        'received_by_agent_at',

        'reminder_email_sent',
        'reminder_email_sent_at',

        'whatsapp_sent',
        'whatsapp_sent_at',

        'reminder_whatsapp_sent',
        'reminder_whatsapp_sent_at',

        'receipt_email_sent',
        'receipt_email_sent_at',

        'receipt_whatsapp_sent',
        'receipt_whatsapp_sent_at',

        'created_by_cron',
        'ignore_tax',
        'ignore_prorated',
        'postpaid',
        'invoice_phone',
        'invoice_cp',
        'qr_code',
        'memo',

        'note',
        'brand_type',

        'type',
        'created_by',
        'generated_at',
        'reference_id',
    ];

    protected $dates = ['deleted_at'];

    public function customers()
    {
        return $this->hasMany(ArInvoiceCustomerV2::class, 'ar_invoice_id', 'id');
    }

    public function payment_list()
    {
        return $this->hasMany(ArInvoicePaymentList::class, 'ar_invoice_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(ArInvoiceV2Log::class, 'ar_invoice_id', 'id');
    }

    public function account_numbers()
    {
        return $this->hasMany(ArInvoiceAccountNumber::class, 'ar_invoice_id', 'id');
    }
}

