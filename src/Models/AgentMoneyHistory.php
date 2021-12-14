<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AgentMoneyHistory extends Model
{
    protected $table = 'agent_money_history';

    protected $fillable = [
        // 'id',
        'agent_id',
        'date',
        'name',
        'money',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'agent_id' => 'integer',
        'date' => 'date:Y-m-d',
        'name' => 'string',
        'money' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
