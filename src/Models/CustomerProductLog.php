<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductLog extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'customer_product_log';

    protected $fillable = [
        // 'id',

        'date',
        'time',
        'title',
        'customer_product_id',
        'customer_product_data',
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
        'customer_product_id' => 'integer',
        'customer_product_data' => 'string',
        'caused_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function caused_by_ref()
    {
        return $this->belongsTo(Employee::class, 'caused_by');
    }
}
