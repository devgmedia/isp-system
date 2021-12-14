<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SpmDirectorApproval extends Model
{
    protected $table = 'spm_director_approval';

    protected $fillable = [
        // 'id',

        'uuid',

        'request_by',
        'request_at',

        'branch_id',
        'chart_of_account_title_id',

        'invalid',

        'created_at',
        'updated_at',

        'read',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',

        'request_by' => 'integer',
        'request_at' => 'datetime',

        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',

        'invalid' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'read' => 'boolean',
    ];

    public function list()
    {
        return $this->hasMany(SpmDirectorApprovalList::class);
    }

    public function request_by_ref()
    {
        return $this->belongsTo(Employee::class, 'request_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function spms()
    {
        return $this->belongsToMany(Spm::class, SpmDirectorApprovalList::class, 'approval_id', 'spm_id')->withPivot('id');
    }
}
