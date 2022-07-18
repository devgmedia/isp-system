<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ApInvoice extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ap_invoice';

    protected $attributes = [
        'memo' => false,
    ];

    protected $fillable = [
        // 'id',

        'supplier_id',
        'number',
        'purchase_order_number',
        'date',
        'due_date',
        'name',
        'retention',
        'stamp_duty',
        'discount',
        'pph_pasal_23',
        'pph_pasal_4_ayat_2',
        'tax',
        'tax_base',
        'total',
        'branch_id',

        'created_at',
        'updated_at',
        
        'uuid',
        'purchase_request_number',
        'pph_pasal_21',
        'purchase_request_category_id',
        'received_date',

        'source_id',

        'chart_of_account_title_id',

        'invoice_number',
        'invoice_file',

        'memo',
        'price',
        'total_without_pph',

        'pph_pasal_26',

        'accounting_division_category_id',
        'journal_project_id',

        'memo_ar_invoice_id',

        'faktur_file',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'supplier_id' => 'integer',
        'number' => 'string',
        'purchase_order_number' => 'string',
        'date' => 'date:Y-m-d',
        'due_date' => 'date:Y-m-d',
        'name' => 'string',
        'retention' => 'double',
        'stamp_duty' => 'double',
        'pph_pasal_23' => 'double',
        'pph_pasal_4_ayat_2' => 'double',
        'discount' => 'double',
        'tax' => 'double',
        'tax_base' => 'double',
        'total' => 'double',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'uuid' => 'string',
        'purchase_request_number' => 'string',
        'pph_pasal_21' => 'integer',
        'purchase_request_category_id' => 'integer',
        'received_date' => 'date:Y-m-d',

        'source_id' => 'integer',

        'chart_of_account_title_id' => 'integer',

        'invoice_number' => 'string',
        'invoice_file' => 'string',

        'memo' => 'boolean',
        'price' => 'double',
        'total_without_pph' => 'double',
        
        'pph_pasal_26' => 'double',

        'accounting_division_category_id' => 'integer',
        'journal_project_id' => 'integer',

        'memo_ar_invoice_id' => 'integer',
        
        'faktur_file' => 'string',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function items()
    {
        return $this->hasMany(ApInvoiceItem::class);
    }

    public function spms()
    {
        return $this->hasMany(Spm::class);
    }

    public function source()
    {
        return $this->belongsTo(ApInvoiceSource::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function journal()
    {
        return $this->hasOne(Journal::class);
    }

    public function journal_ap_invoices()
    {
        return $this->hasMany(JournalApInvoice::class);
    }

    public function journal_items()
    {
        return $this->belongsToMany(JournalItem::class, JournalApInvoice::class)->withPivot('id');
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, JournalApInvoice::class)->withPivot('id');
    }

    public function tax_in()
    {
        return $this->hasOne(TaxIn::class);
    }

    public function settlements()
    {
        return $this->hasMany(ApInvoiceSettlement::class);
    }

    public function accounting_division_category()
    {
        return $this->belongsTo(AccountingDivisionCategory::class);
    }

    public function journal_project()
    {
        return $this->belongsTo(JournalProject::class);
    }

    public function memo_ar_invoice()
    {
        return $this->belongsTo(ArInvoice::class);
    }
}
