<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ArInvoiceConfirm extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_confirm';

    protected $fillable = [
        // 'id',
        'ar_invoice_id',
        
        'message',
        'submit_by',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'ar_invoice_id' => 'integer',

        'message' => 'string',
        'submit_by' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(ArInvoice::class, 'ar_invoice_id');
    }

    public function submit_by_ref()
    {
        return $this->belongsTo(Employee::class, 'submit_by');
    }
}
