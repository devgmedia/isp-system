<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'journal';

    protected $attributes = [
        'posted' => false,
        'auto_created' => false,
        'submit' => false,
    ];

    protected $fillable = [
        // 'id',
        'uuid',
        'date',
        'name',
        'type_id',

        'created_at',
        'updated_at',

        'branch_id',
        'posted',
        'posted_at',
        'auto_created',
        'code_id',
        'menu_id',
        'reference',
        'description',
        'project_id',
        'posted_by',
        'submit_at',
        'submit_by',
        'accounting_division_category_id',

        'ar_invoice_id',
        'ap_invoice_id',
        'cashier_in_id',
        'cashier_out_id',

        'chart_of_account_title_id',
        'submit',
        'default_on_pra_gl_ar',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'date' => 'date:Y-m-d',
        'name' => 'string',
        'type_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'branch_id' => 'integer',
        'posted' => 'boolean',
        'posted_at' => 'datetime',
        'auto_created' => 'boolean',
        'code_id' => 'integer',
        'menu_id' => 'integer',
        'reference' => 'string',
        'description' => 'string',
        'project_id' => 'integer',
        'posted_by' => 'integer',
        'submit_at' => 'datetime',
        'submit_by' => 'integer',
        'accounting_division_category_id' => 'integer',

        'ar_invoice_id' => 'integer',
        'ap_invoice_id' => 'integer',
        'cashier_in_id' => 'integer',
        'cashier_out_id' => 'integer',

        'chart_of_account_title_id' => 'integer',
        'submit' => 'boolean',
        'default_on_pra_gl_ar' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(JournalType::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function code()
    {
        return $this->belongsTo(JournalCode::class);
    }

    public function menu()
    {
        return $this->belongsTo(AccountingMenu::class);
    }

    public function project()
    {
        return $this->belongsTo(JournalProject::class);
    }

    public function accounting_division_category()
    {
        return $this->belongsTo(AccountingDivisionCategory::class);
    }

    public function items()
    {
        return $this->hasMany(JournalItem::class);
    }

    public function posted_by_ref()
    {
        return $this->belongsTo(Employee::class, 'posted_by');
    }

    public function submit_by_ref()
    {
        return $this->belongsTo(Employee::class, 'submit_by');
    }

    public function ar_invoice()
    {
        return $this->belongsTo(ArInvoice::class);
    }

    public function ap_invoice()
    {
        return $this->belongsTo(ApInvoice::class);
    }

    public function cashier_in()
    {
        return $this->belongsTo(CashierIn::class);
    }

    public function cashier_out()
    {
        return $this->belongsTo(CashierOut::class);
    }

    public function journal_ar_invoices()
    {
        return $this->hasMany(JournalArInvoice::class);
    }

    public function ar_invoices()
    {
        return $this->belongsToMany(ArInvoice::class, JournalArInvoice::class)->withPivot('id');
    }

    public function journal_ap_invoices()
    {
        return $this->hasMany(JournalApInvoice::class);
    }

    public function ap_invoices()
    {
        return $this->belongsToMany(ApInvoice::class, JournalApInvoice::class)->withPivot('id');
    }

    public function journal_cashier_ins()
    {
        return $this->hasMany(JournalCashierIn::class);
    }

    public function cashier_ins()
    {
        return $this->belongsToMany(CashierIn::class, JournalCashierIn::class)->withPivot('id');
    }

    public function journal_cashier_outs()
    {
        return $this->hasMany(JournalCashierOut::class);
    }

    public function cashier_outs()
    {
        return $this->belongsToMany(CashierOut::class, JournalCashierOut::class)->withPivot('id');
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }
}
