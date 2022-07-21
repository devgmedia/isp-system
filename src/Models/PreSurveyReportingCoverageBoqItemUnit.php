<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreSurveyReportingCoverageBoqItemUnit extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'pre_survey_reporting_coverage_boq_item_unit';

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
