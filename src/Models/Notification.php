<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';

    protected $fillable = [
        // 'id',
        'title',
        'message',
        'date',
        'agent_id',
        'customer_id',
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
        'date' => 'date:Y-m-d',
        'agent_id' => 'integer',
        'customer_id' => 'integer',
        'level' => 'string',
        'read_at' => 'datetime',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }   

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }   
}
