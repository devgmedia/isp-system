<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Rab extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'rab';

    protected $fillable = [

        'number',
        'date',
        'survey_reporting_coverage_id',
        'approval_token',
        'sales_name',
        'marketing_approved_by',
        'marketing_approved_date',
        'marketing_approved_name',
        'finance_approved_by',
        'finance_approved_date',
        'finance_approved_name',
        'director_approved_by',
        'director_approved_date',
        'director_approved_name',
        'total',
        'branch_id',
        'sub_department_id',
        'department_id',
        'division_id',

        'survey_reporting_id',
        'pre_customer_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'date' => 'date',
        'survey_reporting_coverage_id' => 'integer',
        'approval_token' => 'string',
        'sales_name' => 'string',
        'marketing_approved_by' => 'integer',
        'marketing_approved_date' => 'date',
        'marketing_approved_name' => 'string',
        'finance_approved_by' => 'integer',
        'finance_approved_date' => 'date',
        'finance_approved_name' => 'string',
        'director_approved_by' => 'integer',
        'director_approved_date' => 'date',
        'director_approved_name' => 'string',
        'total' => 'integer',
        'branch_id' => 'integer',
        'sub_department_id' => 'integer',
        'department_id' => 'integer',
        'division_id' => 'integer',

        'survey_reporting_id' => 'integer',
        'pre_customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function item()
    {
        return $this->hasMany(RabItem::class);
    }

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class, 'pre_customer_id', 'id');
    }

    public function survey_reporting()
    {
        return $this->belongsTo(SurveyReporting::class);
    }

    public function survey_reporting_coverage()
    {
        return $this->belongsTo(SurveyReportingCoverage::class);
    }
}
