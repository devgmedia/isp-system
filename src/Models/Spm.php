<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Spm extends Model
{
    protected $table = 'spm';

    protected $fillable = [
        // 'id',

        'uuid',
        'name',
        'cashier_out_category_id',
        'urgent',
        'ap_invoice_id',
        'due_date',
        'cash_bank_id',
        'receiver_id',
        'number',
        'accounting_division_category_id',
        'payment_method_id',
        'updated_by',

        'approval_id',

        'branch_manager_approved',
        'branch_manager_approved_by',
        'branch_manager_approved_at',

        'finance_approved',
        'finance_approved_by',
        'finance_approved_at',

        'director_approved',
        'director_approved_by',
        'director_approved_at',

        'marked',
        'marked_at',

        'authorized',
        'authorized_at',

        'cancel',
        'cancel_at',

        'note',
        'branch_id',

        'created_at',
        'updated_at',

        'paid_total',

        'branch_manager_approval_note',
        'finance_approval_note',
        'director_approval_note',

        'marked_date',
        'authorized_date',

        'chart_of_account_title_id',

        'general_manager_approved',
        'general_manager_approved_by',
        'general_manager_approved_at',
        'general_manager_approval_note',

        'journal_project_id',

        'remaining_payment',
        'date',
        'memo',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'name' => 'string',
        'cashier_out_category_id' => 'integer',
        'urgent' => 'boolean',
        'ap_invoice_id' => 'integer',
        'due_date' => 'date:Y-m-d',
        'cash_bank_id' => 'integer',
        'receiver_id' => 'integer',
        'number' => 'string',
        'accounting_division_category_id' => 'integer',
        'payment_method_id' => 'integer',
        'updated_by' => 'integer',

        'approval_id' => 'string',

        'branch_manager_approved' => 'boolean',
        'branch_manager_approved_by' => 'integer',
        'branch_manager_approved_at' => 'datetime',

        'finance_approved' => 'boolean',
        'finance_approved_by' => 'integer',
        'finance_approved_at' => 'datetime',

        'director_approved' => 'boolean',
        'director_approved_by' => 'integer',
        'director_approved_at' => 'datetime',

        'marked' => 'boolean',
        'marked_at' => 'datetime',

        'authorized' => 'boolean',
        'authorized_at' => 'datetime',

        'cancel' => 'boolean',
        'cancel_at' => 'datetime',

        'note' => 'string',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'paid_total' => 'double',

        'branch_manager_approval_note' => 'string',
        'finance_approval_note' => 'string',
        'director_approval_note' => 'string',

        'marked_date' => 'date:Y-m-d',
        'authorized_date' => 'date:Y-m-d',

        'chart_of_account_title_id' => 'integer',

        'general_manager_approved' => 'boolean',
        'general_manager_approved_by' => 'integer',
        'general_manager_approved_at' => 'datetime',
        'general_manager_approval_note' => 'string',

        'journal_project_id' => 'integer',
        
        'remaining_payment' => 'double',
        'date' => 'date:Y-m-d',
        'memo' => 'boolean',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function cashier_out_category()
    {
        return $this->belongsTo(CashierOutCategory::class);
    }

    public function invoice()
    {
        return $this->belongsTo(ApInvoice::class, 'ap_invoice_id');
    }

    public function cash_bank()
    {
        return $this->belongsTo(CashBank::class);
    } 

    public function receiver()
    {
        return $this->belongsTo(SpmReceiver::class);
    }

    public function accounting_division_category()
    {
        return $this->belongsTo(AccountingDivisionCategory::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(SpmPaymentMethod::class);
    }

    public function updated_by_ref()
    {
        return $this->belongsTo(Employee::class, 'updated_by');
    }

    public function branch_manager_approved_by_ref()
    {
        return $this->belongsTo(Employee::class, 'branch_manager_approved_by');
    }

    public function finance_approved_by_ref()
    {
        return $this->belongsTo(Employee::class, 'finance_approved_by');
    }

    public function general_manager_approved_by_ref()
    {
        return $this->belongsTo(Employee::class, 'general_manager_approved_by');
    }

    public function director_approved_by_ref()
    {
        return $this->belongsTo(Employee::class, 'director_approved_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function branch_manager_approvals()
    {
        return $this->belongsToMany(SpmBranchManagerApproval::class, SpmBranchManagerApprovalList::class, 'spm_id', 'approval_id')->withPivot('id');
    }

    public function finance_approvals()
    {
        return $this->belongsToMany(SpmFinanceApproval::class, SpmFinanceApprovalList::class, 'spm_id', 'approval_id')->withPivot('id');
    }

    public function general_manager_approvals()
    {
        return $this->belongsToMany(SpmGeneralManagerApproval::class, SpmGeneralManagerApprovalList::class, 'spm_id', 'approval_id')->withPivot('id');
    }

    public function director_approvals()
    {
        return $this->belongsToMany(SpmDirectorApproval::class, SpmDirectorApprovalList::class, 'spm_id', 'approval_id')->withPivot('id');
    }

    public function journal_project()
    {
        return $this->belongsTo(JournalProject::class);
    }
}
