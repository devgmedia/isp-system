<?php

namespace GMedia\IspSystem\Models;

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
