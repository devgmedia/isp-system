<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AgentCashWithdrawal extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'agent_cash_withdrawal';

    protected $fillable = [
        // 'id',
        'agent_id',
        'date',
        'money',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'agent_id' => 'integer',
        'date' => 'date:Y-m-d',
        'money' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
