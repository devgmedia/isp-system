<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TrialReporting extends Model
{
    protected $table = 'trial_reporting';

    protected $fillable = [
        // 'id',
        'uuid',
        'trial_request_id',
        'pre_customer_id',
        'created_at',
        'updated_at',
        'branch_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'trial_request_id' => 'interger',
        'pre_customer_id' => 'integer',
        'description' => 'string',
        'branch_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
