<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SpmBranchManagerApprovalList extends Pivot
{
    public $incrementing = true;
    protected $table = 'spm_branch_manager_approval_list';

    protected $fillable = [
        // 'id',

        'approval_id',

        'spm_id',
        'spm_approval_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'approval_id' => 'integer',

        'spm_id' => 'integer',
        'spm_approval_id' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function approval()
    {
        return $this->belongsTo(SpmBranchManagerApproval::class);
    }

    public function spm()
    {
        return $this->belongsTo(Spm::class);
    }
}
