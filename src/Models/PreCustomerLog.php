<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerLog extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_log';

    protected $fillable = [
        // 'id',

        'date',
        'time',
        'title',
        'pre_customer_id',
        'pre_customer_data',
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
        'pre_customer_id' => 'integer',
        'pre_customer_data' => 'string',
        'caused_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
    }

    public function caused_by_ref()
    {
        return $this->belongsTo(Employee::class, 'caused_by');
    }
}
