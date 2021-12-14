<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyRequest extends Model
{
    protected $table = 'survey_request';

    protected $fillable = [
        // 'id',
        'pre_survey_reporting_id',
        'pre_customer_id',
        'request_by',
        'request_date',
        'request_name',
        'branch_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'pre_survey_reporting_id' => 'integer',
        'pre_customer_id' => 'integer',
        'request_by' => 'integer',
        'request_date' => 'date',
        'request_name' => 'string',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
