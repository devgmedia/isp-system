<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerRequestLog extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'pre_customer_request_log';

    protected $fillable = [
        // 'id',

        'date',
        'time',
        'title',
        'pre_customer_request_id',
        'pre_customer_request_data',
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
        'pre_customer_request_id' => 'integer',
        'pre_customer_request_data' => 'string',
        'caused_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer_request()
    {
        return $this->belongsTo(PreCustomerRequest::class);
    }

    public function caused_by_ref()
    {
        return $this->belongsTo(Employee::class, 'caused_by');
    }
}
