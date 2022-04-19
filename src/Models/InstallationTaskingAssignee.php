<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationTaskingAssignee extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'installation_tasking_assignee';

    protected $fillable = [
        // 'id',
        'installation_tasking_id',
        'assignor',
        'assignee',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'installation_tasking_id' => 'integer',
        'assignor' => 'integer',
        'assignee' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
