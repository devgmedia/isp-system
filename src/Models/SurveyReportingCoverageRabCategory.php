<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyReportingCoverageRabCategory extends Model
{
    protected $table = 'survey_reporting_coverage_rab_category';

    protected $fillable = [
        // 'id',
        'name',  
        'created_at',
        'updated_at', 
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',  
        'created_at' => 'datetime',
        'updated_at' => 'datetime', 
    ];
}
