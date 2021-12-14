<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationTasking extends Model
{
    protected $table = 'installation_tasking';

    protected $fillable = [
        // 'id',
        'uuid',
        'installation_request_id',
        'pre_customer_id',
        'branch_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'installation_request_id' => 'integer',
        'pre_customer_id' => 'integer',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function assignees()
    {
        return $this->hasMany(InstallationTaskingAssignee::class);
    }

}
