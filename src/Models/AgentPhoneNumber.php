<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AgentPhoneNumber extends Model
{
    protected $table = 'agent_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'agent_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'agent_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
