<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TrialQuestionAnswer extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'trial_reporting';

    protected $fillable = [
        // 'id',
        'trial_reporting_id',
        'pre_customer_id',
        'question_id',
        'question_answer',
        'question_answer_description',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'trial_reporting_id' => 'interger',
        'pre_customer_id' => 'integer',
        'question_id' => 'integer',
        'question_answer' => 'boolean',
        'question_answer_description' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
