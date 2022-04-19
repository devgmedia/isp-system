<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyTasking extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'survey_tasking';

    protected $fillable = [
        // 'id',
        'uuid',
        'survey_request_id',
        'pre_customer_id',
        'created_at',
        'updated_at',
        'branch_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'survey_request_id'  => 'integer',
        'pre_customer_id'  => 'integer',
        'branch_id'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function assignees()
    {
        return $this->hasMany(SurveyTaskingAssignee::class);
    }

    public function pre_customer()
    {
        return $this->hasOne(PreCustomer::class);
    }

}
