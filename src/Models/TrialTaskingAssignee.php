<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TrialTaskingAssignee extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'trial_tasking_assignee';

    protected $fillable = [
        // 'id',
        'uuid',
        'trial_tasking_id',
        'assignor',
        'assignee',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'trial_tasking_id'  => 'integer',
        'assignor'  => 'integer',
        'assignee'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    public function trial_tasking()
    {
        return $this->belongsTo(TrialTasking::class);
    }
}
