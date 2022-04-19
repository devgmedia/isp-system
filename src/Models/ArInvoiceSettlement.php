<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceSettlement extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_settlement';

    protected $fillable = [
        // 'id',
        'uuid',

        'branch_id',

        'created_at',
        'updated_at',

        'chart_of_account_title_id',

        'date',        
        'memo',
        'memo_confirm',

        'invoice',
        'admin',
        'down_payment',
        'marketing_fee',
        'pph_pasal_22',
        'pph_pasal_23',
        'ppn',

        'total',

        'brand_id',
        'memo_to',
        'memo_confirm_date',

        'invoice_number',
        'sid',
        'cid',
        'customer_name',
        'product_id',
        'customer_category_id',

        'number',

        'receiver',
        'received_from',
        'product_name',
        'receiver_address',
        'receiver_city',

        'via_virtual_account',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'chart_of_account_title_id' => 'integer',

        'date' => 'date:Y-m-d',
        'memo' => 'boolean',
        'memo_confirm' => 'boolean',

        'invoice' => 'double',
        'admin' => 'double',
        'down_payment' => 'double',
        'marketing_fee' => 'double',
        'pph_pasal_22' => 'double',
        'pph_pasal_23' => 'double',
        'ppn' => 'double',

        'total' => 'double',

        'brand_id' => 'integer',
        'memo_to' => 'integer',
        'memo_confirm_date' => 'date:Y-m-d',

        'invoice_number' => 'string',
        'sid' => 'string',
        'cid' => 'string',
        'customer_name' => 'string',
        'product_id' => 'integer',
        'customer_category_id' => 'integer',

        'number' => 'string',

        'receiver' => 'string',
        'received_from' => 'string',
        'product_name' => 'string',
        'receiver_address' => 'string',
        'receiver_city' => 'string',

        'via_virtual_account' => 'boolean',
    ];

    public function ar_invoice_settlement_invoices()
    {
        return $this->hasMany(ArInvoiceSettlementInvoice::class, 'ar_invoice_settlement_id');
    }

    public function invoices()
    {
        return $this->belongsToMany(ArInvoice::class, ArInvoiceSettlementInvoice::class, 'ar_invoice_settlement_id', 'ar_invoice_id')->withPivot('id');
    }

    public function ar_invoice_settlement_cashiers()
    {
        return $this->hasMany(ArInvoiceSettlementCashier::class, 'ar_invoice_settlement_id');
    }

    public function cashiers()
    {
        return $this->belongsToMany(CashierIn::class, ArInvoiceSettlementCashier::class, 'ar_invoice_settlement_id', 'cashier_in_id')->withPivot('id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function memo_to_ref()
    {
        return $this->belongsTo(Branch::class, 'memo_to');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer_category()
    {
        return $this->belongsTo(CustomerCategory::class);
    }
}
