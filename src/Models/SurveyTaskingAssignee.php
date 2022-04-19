<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyTaskingAssignee extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'survey_tasking_assignee';

    protected $fillable = [
        // 'id',
        'uuid',
        'survey_tasking_id',
        'assignor',
        'assignee',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'survey_tasking_id'  => 'integer',
        'assignor'  => 'integer',
        'assignee'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    public function survey_tasking()
    {
        return $this->belongsTo(SurveyTasking::class);
    }
}
