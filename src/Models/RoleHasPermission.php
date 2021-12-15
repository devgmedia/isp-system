<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'role_has_permissions';

    protected $fillable = [
        // 'id',
        'permission_id',
        'role_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'permission_id' => 'integer',
        'role_id' => 'integer',
    ];
}
