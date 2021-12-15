<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLog extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_log';

    protected $fillable = [
        // 'id',

        'date',
        'time',
        'title',
        'customer_id',
        'customer_data',
        'caused_by',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'date' => 'date:Y-m-d',
        'time' => 'time:H:i:s',
        'title' => 'string',
        'customer_id' => 'integer',
        'customer_data' => 'string',
        'caused_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function caused_by_ref()
    {
        return $this->belongsTo(Employee::class, 'caused_by');
    }
}
