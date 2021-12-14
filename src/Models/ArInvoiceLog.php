<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceLog extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_log';

    protected $fillable = [
        // 'id',

        'date',
        'time',
        'title',
        'ar_invoice_id',
        'ar_invoice_data',
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
        'ar_invoice_id' => 'integer',
        'ar_invoice_data' => 'string',
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
