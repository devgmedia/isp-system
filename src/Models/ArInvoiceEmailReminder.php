<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceEmailReminder extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'ar_invoice_email_reminder';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',

        'sent_by',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'integer',

        'sent_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(ArInvoice::class, 'ar_invoice_id');
    }

    public function sent_by_ref()
    {
        return $this->belongsTo(Employee::class, 'sent_by');
    }
}
