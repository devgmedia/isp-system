<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'branch';

    protected $fillable = [
        // 'id',
        'name',
        'code',

        'latitude',
        'longitude',
        'timezone',

        'regional_id',
        'company_id',

        'created_at',
        'updated_at',

        'uuid',

        'spm_is_active',
        'spm_pic',
        'spm_pic_email',

        'pre_customer_request_sales_email',

        'billing_phone_number',
        'billing_email',
        'billing_preparer',
        'billing_approver',
        'billing_address',
        'billing_city',

        'pr_purchasing_approval_email',
        'pr_purchasing_approval_name',

        'pr_finance_approval_email',
        'pr_finance_approval_name',
        
        'pr_general_manager_approval_email',
        'pr_genaral_manager_approval_name',
        
        'pr_director_approval_email',
        'pr_director_approval_name',
        
        'po_finance_approval_email',
        'po_finance_approval_name',
        
        'po_general_manager_approval_email',
        'po_general_manager_approval_name',
        
        'po_director_approval_email',
        'po_director_approval_name',

    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        
        'latitude' => 'double',
        'longitude' => 'double',
        'timezone' => 'datetime',

        'regional_id' => 'integer',
        'company_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'uuid' => 'string',

        'spm_is_active' => 'boolean',
        'spm_pic' => 'string',
        'spm_pic_email' => 'string',

        'pre_customer_request_sales_email' => 'string',

        'billing_phone_number' => 'string',
        'billing_email' => 'string',
        'billing_preparer' => 'string',
        'billing_approver' => 'string',
        'billing_address' => 'string',
        'billing_city' => 'string',

        'pr_purchasing_approval_email' => 'string',
        'pr_purchasing_approval_name' => 'string',

        'pr_finance_approval_email' => 'string',
        'pr_finance_approval_name' => 'string',
        
        'pr_general_manager_approval_email' => 'string',
        'pr_genaral_manager_approval_name' => 'string',
        
        'pr_director_approval_email' => 'string',
        'pr_director_approval_name' => 'string',
        
        'po_finance_approval_email' => 'string',
        'po_finance_approval_name' => 'string',
        
        'po_general_manager_approval_email' => 'string',
        'po_general_manager_approval_name' => 'string',
        
        'po_director_approval_email' => 'string',
        'po_director_approval_name' => 'string',
    ];

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }

    public function sub_departments()
    {
        return $this->hasMany(SubDepartment::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function invoices()
    {
        return $this->hasMany(ArInvoice::class);
    }

    public function pre_customer_request_cc_emails()
    {
        return $this->hasMany(BranchPreCustomerRequestCcEmail::class);
    }

    public function chart_of_account_titles()
    {
        return $this->hasMany(ChartOfAccountTitle::class);
    }
}