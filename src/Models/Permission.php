<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'permissions';

    protected $fillable = [
        // 'id',
        'name',
        'guard_name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'guard_name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, RoleHasPermission::class);
    }
}
