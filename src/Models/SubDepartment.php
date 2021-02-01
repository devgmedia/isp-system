<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use GMedia\IspSystem\Models\Department;
use GMedia\IspSystem\Models\Branch;

class SubDepartment extends Model
{
    protected $table = 'sub_department';

    protected $fillable = [
        // 'id',
        'name',
        'department_id',
        'branch_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',
        'department_id' => 'integer',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
