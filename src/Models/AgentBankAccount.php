<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AgentBankAccount extends Model
{
    protected $table = 'agent_bank_account';

    protected $fillable = [
        // 'id',
        'bank_id',
        'number',
        'on_behalf_of',
        'agent_id',
        
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'bank_id' => 'integer',
        'number' => 'string',
        'on_behalf_of' => 'string',
        'agent_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
