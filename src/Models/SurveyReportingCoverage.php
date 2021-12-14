<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyReportingCoverage extends Model
{
    protected $table = 'survey_reporting_coverage';

    protected $fillable = [
        // 'id', 
        'survey_reporting_id',
        'media_id',
        'media_vendor_id',
        'olt_id',
        'odp_id',
        'odp_distance',
        'odp_distance_unit',
        'end_point',
        'tower_hight',
        'tower_hight_unit',
        'work_duration',
        'work_duration_unit',  
        'created_at',
        'updated_at',

        'bts_id',
        'bts_distance',
        'tower_type_id',

        'note',
        'cable_type',

        'pole_7_meters',
        'pole_9_meters',
    ];

    protected $hidden = [];

    protected $casts = [
        // 'id' => 'integer', 
        'survey_reporting_id' => 'interger',
        'media_id' => 'interger',
        'media_vendor_id'  => 'integer', 
        'olt_id' => 'integer',
        'odp_id' => 'integer',
        'odp_distance' => 'integer',
        'odp_distance_unit' => 'integer',
        'end_point' => 'string',
        'tower_hight' => 'integer',
        'tower_hight_unit' => 'integer',
        'work_duration' => 'integer',
        'work_duration_unit' => 'integer', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'bts_id' => 'integer', 
        'bts_distance' => 'integer',
        'tower_type_id' => 'integer', 

        'note' => 'string',
        'cable_type' => 'string',

        'pole_7_meters' => 'integer', 
        'pole_9_meters' => 'integer', 
    ];

    // public function coverages()
    // {
    //     return $this->hasMany(PreSurveyRequestCoverage::class);
    // }

    public function coverage_boq_items()
    {
        return $this->hasMany(SurveyReportingCoverageBoqItem::class);
    }

    public function coverage_rab_items()
    {
        return $this->hasMany(SurveyReportingCoverageRabItem::class);
    }
}
