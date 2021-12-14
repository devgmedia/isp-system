<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'department';

    protected $fillable = [
        // 'id',
        'name',
        'division_id',

        'branch_id',
        'regional_id',
        'company_id',

        'created_at',
        'updated_at',

        'pr_approval_email',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'division_id' => 'integer',
        
        'branch_id' => 'integer',
        'regional_id' => 'integer',
        'company_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'pr_approval_email' => 'string',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
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
