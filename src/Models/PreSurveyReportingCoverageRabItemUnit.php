<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreSurveyReportingCoverageRabItemUnit extends Model
{
    protected $table = 'pre_survey_reporting_coverage_rab_item_unit';

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
