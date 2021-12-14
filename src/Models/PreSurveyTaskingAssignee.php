<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model; 

class PreSurveyTaskingAssignee extends Model
{
    protected $table = 'pre_survey_tasking_assignee';

    protected $fillable = [
        // 'id',
        'uuid',
        'pre_survey_tasking_id', 
        'assignor',
        'assignee',
        'created_at',
        'updated_at', 
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'pre_survey_tasking_id'  => 'integer', 
        'assignor'  => 'integer', 
        'assignee'  => 'integer', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    public function pre_survey_tasking()
    {
        return $this->belongsTo(PreSurveyTasking::class);
    }
}
