<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $connection = 'activity_log';
    protected $connection = 'isp_system';
    protected $table = 'activity_log';

    protected $fillable = [
        // 'id',

        'log_name',
        'description',

        'subject_id',
        'subject_type',

        'causer_id',
        'causer_name',

        'properties',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'log_name' => 'string',
        'description' => 'string',

        'subject_id' => 'integer',
        'subject_type' => 'string',

        'causer_id' => 'integer',
        'causer_name' => 'string',
        
        'properties' => 'collection',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
