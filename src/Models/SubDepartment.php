<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Branch;

class SubDepartment extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'sub_department';

    protected $fillable = [
        // 'id',
        'name',
        'department_id',

        'branch_id',
        'regional_id',
        'company_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'department_id' => 'integer',
        
        'branch_id' => 'integer',
        'regional_id' => 'integer',
        'company_id' => 'integer',

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

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function company()
    {
        return $this->belongsTo(Regional::class);
    }
}
