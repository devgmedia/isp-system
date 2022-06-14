<?php

namespace Gmedia\IspSystem\Models;

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

        'proof_of_transaction',

        'agent_name',
        'agent_alias_name',

        'branch_id',
        'uuid',
        'brand_id',

        'whatsapp_sent_at',
        'whatsapp_sent_by',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'agent_id' => 'integer',
        'date' => 'date:Y-m-d',
        'money' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'proof_of_transaction' => 'string',
        
        'agent_name' => 'string',
        'agent_alias_name' => 'string',
        
        'branch_id' => 'integer',
        'uuid' => 'string',
        'brand_id' => 'integer',

        'whatsapp_sent_at' => 'datetime',
        'whatsapp_sent_by' => 'integer',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    
    public function whatsapp_sent_by_ref()
    {
        return $this->belongsTo(Employee::class, 'whatsapp_sent_by');
    }
}
