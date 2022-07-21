<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class JournalItem extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'journal_item';

    protected $attributes = [
        'locked_by_journal' => false,
        'locked_by_journal_relation' => false,
    ];

    protected $fillable = [
        // 'id',
        'journal_id',
        'chart_of_account_id',
        'debit',
        'credit',
        'created_at',
        'updated_at',
        'name',
        'chart_of_account_card_id',

        'locked_by_journal',
        'locked_by_journal_relation',

        'journal_ar_invoice_id',
        'journal_ap_invoice_id',
        'journal_cashier_in_id',
        'journal_cashier_out_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'journal_id' => 'integer',
        'chart_of_account_id' => 'integer',
        'debit' => 'double',
        'credit' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'name' => 'string',
        'chart_of_account_card_id' => 'integer',

        'locked_by_journal' => 'boolean',
        'locked_by_journal_relation' => 'boolean',

        'journal_ar_invoice_id' => 'integer',
        'journal_ap_invoice_id' => 'integer',
        'journal_cashier_in_id' => 'integer',
        'journal_cashier_out_id' => 'integer',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function chart_of_account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function chart_of_account_card()
    {
        return $this->belongsTo(ChartOfAccountCard::class);
    }

    public function journal_ar_invoice()
    {
        return $this->belongsTo(JournalArInvoice::class);
    }

    public function journal_ap_invoice()
    {
        return $this->belongsTo(JournalApInvoice::class);
    }

    public function journal_cashier_in()
    {
        return $this->belongsTo(JournalCashierIn::class);
    }

    public function journal_cashier_out()
    {
        return $this->belongsTo(JournalCashierOut::class);
    }
}
