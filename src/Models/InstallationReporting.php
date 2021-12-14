<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationReporting extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'installation_reporting';

    protected $fillable = [
        // 'id',
        'uuid',
        'installation_tasking_id',
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
        'installation_tasking_id' => 'interger',
        'pre_customer_id' => 'integer',
        'branch_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'content' => 'string',
        'owncloud_link' => 'string',
    ];
}
