<?php

namespace Gmedia\IspSystem\Models;

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
        'time' => 'datetime:H:i:s',
        'title' => 'string',
        'ar_invoice_id' => 'integer',
        'ar_invoice_data' => 'string',
        'caused_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(ArInvoice::class, 'ar_invoice_id');
    }

    public function caused_by_ref()
    {
        return $this->belongsTo(Employee::class, 'caused_by');
    }
}
