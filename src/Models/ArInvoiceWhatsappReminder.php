<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceWhatsappReminder extends Model
{
    protected $table = 'ar_invoice_whatsapp_reminder';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',
        'broadcast_job_id',

        'log_status',

        'broadcast_name',
        'job_status',

        'job_total_failed',
        'job_total_read',
        'job_total_received',
        'job_total_recipient',
        'job_total_sent',

        'created_at',
        'updated_at',

        'response_log_status',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'integer',
        'broadcast_job_id' => 'integer',

        'log_status' => 'integer',

        'broadcast_name' => 'string',
        'job_status' => 'integer',

        'job_total_failed' => 'integer',
        'job_total_read' => 'integer',
        'job_total_received' => 'integer',
        'job_total_recipient' => 'integer',
        'job_total_sent' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'response_log_status' => 'string',
    ];
}
