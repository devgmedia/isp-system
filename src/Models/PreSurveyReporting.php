<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreSurveyReporting extends Model
{
    protected $table = 'pre_survey_reporting';

    protected $fillable = [
        // 'id',
        'uuid', 
        'pre_survey_tasking_id',
        'pre_customer_id',
        'created_at',
        'updated_at',
        'branch_id',

        'content',
        'owncloud_link',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer', 
        'pre_survey_tasking_id' => 'interger',
        'pre_customer_id' => 'integer', 
        'branch_id' => 'integer', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'content' => 'string',
        'owncloud_link' => 'string',
    ];

    public function coverages()
    {
        return $this->hasMany(PreSurveyReportingCoverage::class);
    }
}
