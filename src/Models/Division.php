<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'division';

    protected $fillable = [
        // 'id',
        'name',

        'branch_id',
        'regional_id',
        'company_id',

        'created_at',
        'updated_at',

        'pr_approval_email',
        'pr_approval_2nd_email',

        'parent',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'branch_id' => 'integer',
        'regional_id' => 'integer',
        'company_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'pr_approval_email' => 'string',
        'pr_approval_2nd_email' => 'string',

        'parent' => 'integer',
    ];

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

    public function parent_ref()
    {
        return $this->belongsTo(Division::class);
    }
}
