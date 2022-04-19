<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JournalCashierOut extends Pivot
{
    public $incrementing = true;
    protected $connection = 'isp_system';
    protected $table = 'journal_cashier_out';

    protected $fillable = [
        // 'id',
        'journal_id',
        'cashier_out_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'journal_id' => 'integer',
        'cashier_out_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    function cashier_out()
    {
        return $this->belongsTo(CashierOut::class);
    }

    function journal_item()
    {
        return $this->hasOne(JournalItem::class, 'journal_cashier_out_id');
    }
}
