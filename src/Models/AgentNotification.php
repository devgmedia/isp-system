<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AgentNotification extends Model
{
    protected $table = 'agent_notification';

    protected $fillable = [
        // 'id',
        'title',
        'message',
        'date',
        'ar_invoice_id',
        'agent_id',
        'level',
        'read_at',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'message' => 'string',
        'date' => 'datetime',
        'ar_invoice_id' => 'integer',
        'agent_id' => 'integer',
        'level' => 'string',
        'read_at' => 'datetime',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
