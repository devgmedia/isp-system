<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JournalArInvoice extends Pivot
{
    public $incrementing = true;
    protected $table = 'journal_ar_invoice';

    protected $fillable = [
        // 'id',
        'journal_id',
        'ar_invoice_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'journal_id' => 'integer',
        'ar_invoice_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    function ar_invoice()
    {
        return $this->belongsTo(ArInvoice::class);
    }

    function journal_item()
    {
        return $this->hasOne(JournalItem::class, 'journal_ar_invoice_id');
    }
}
