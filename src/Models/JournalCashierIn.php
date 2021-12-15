<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JournalCashierIn extends Pivot
{
    public $incrementing = true;
    protected $table = 'journal_cashier_in';

    protected $fillable = [
        // 'id',
        'journal_id',
        'cashier_in_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'journal_id' => 'integer',
        'cashier_in_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    function cashier_in()
    {
        return $this->belongsTo(CashierIn::class);
    }

    function journal_item()
    {
        return $this->hasOne(JournalItem::class, 'journal_cashier_in_id');
    }
}
