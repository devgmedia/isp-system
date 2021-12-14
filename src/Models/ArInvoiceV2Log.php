<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogCausedDatetime;

class ArInvoiceV2Log extends Model
{
    use LogCausedDatetime;

    protected $table = 'ar_invoice_log_v2';

    protected $fillable = [
        'date',
        'time',
        'title',
        'ar_invoice_id',
        'ar_invoice_data',
        'caused_by',

        'created_at',
        'updated_at',
    ];

    public function caused()
    {
        return $this->belongsTo(Employee::class, 'caused_by');
    }
}
