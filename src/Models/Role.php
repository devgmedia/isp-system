<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'roles';

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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, RoleHasPermission::class);
    }
}
