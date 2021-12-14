<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreSurveyReportingCoverageRabItem extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_survey_reporting_coverage_rab_item';

    protected $fillable = [
        // 'id',
        'pre_survey_reporting_coverage_id',
        'brand_id',
        'brand_product_id',
        'name',  
        'brand_name',
        'brand_product_name',
        'quantity',
        'unit_id',
        'created_at',
        'updated_at',
        
        'category_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'pre_survey_reporting_coverage_id' => 'integer',  
        'brand_id' => 'integer',  
        'brand_product_id' => 'integer',  
        'name' => 'string',  
        'brand_name' => 'string', 
        'brand_product_name' => 'string', 
        'quantity' => 'integer',  
        'unit_id' => 'integer',  
        'created_at' => 'datetime',
        'updated_at' => 'datetime', 
        
        'category_id' => 'integer',
    ];
}
