<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TrialRequest extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'trial_request';

    protected $fillable = [
        // 'id',
        'installation_reporting_id',
        'pre_customer_id',
        'request_by',
        'request_date',
        'request_name',
        'branch_id',
        'start_date',
        'end_date',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'installation_reporting_id' => 'integer',
        'pre_customer_id' => 'integer',
        'request_by' => 'integer',
        'request_date' => 'date',
        'request_name' => 'string',
        'branch_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
