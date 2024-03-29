<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JournalApInvoice extends Pivot
{
    public $incrementing = true;

    protected $connection = 'isp_system';

    protected $table = 'journal_ap_invoice';

    protected $fillable = [
        // 'id',
        'journal_id',
        'ap_invoice_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'journal_id' => 'integer',
        'ap_invoice_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function ap_invoice()
    {
        return $this->belongsTo(ApInvoice::class);
    }

    public function journal_item()
    {
        return $this->hasOne(JournalItem::class, 'journal_ap_invoice_id');
    }
}
