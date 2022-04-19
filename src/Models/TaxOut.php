<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TaxOut extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'tax_out';

    protected $attributes = [
        'pph_pasal_21' => 0,
        'pph_pasal_23' => 0,
        'pph_pasal_4_ayat_2' => 0,
        'ppn' => 0,
    ];

    protected $fillable = [
        // 'id',
        'uuid',

        'ar_invoice_id',

        'branch_id',
        'chart_of_account_title_id',

        'submit',
        'submit_by',
        'submit_at',

        'pph_pasal_21',
        'pph_pasal_23',
        'pph_pasal_4_ayat_2',
        'ppn',
        'bukti_potong',

        'masa',

        'customer_id',
        'date',
        'invoice_date',
        'customer_name',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',

        'ar_invoice_id' => 'integer',
        
        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',

        'submit' => 'boolean',
        'submit_by' => 'integer',
        'submit_at' => 'datetime',

        'pph_pasal_21' => 'double',
        'pph_pasal_23' => 'double',
        'pph_pasal_4_ayat_2' => 'double',
        'ppn' => 'double',
        'bukti_potong' => 'string',

        'masa' => 'integer',

        'customer_id' => 'integer',
        'date' => 'date:Y-m-d',
        'invoice_date' => 'date:Y-m-d',
        'customer_name' => 'string',
    ];

    public function ar_invoice()
    {
        return $this->belongsTo(ArInvoice::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }

    public function submit_by_ref()
    {
        return $this->belongsTo(Employee::class, 'submit_by');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
