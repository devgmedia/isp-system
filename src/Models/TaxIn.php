<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TaxIn extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'tax_in';

    protected $attributes = [
        'pph_pasal_21' => 0,
        'pph_pasal_23' => 0,
        'pph_pasal_4_ayat_2' => 0,
        'ppn' => 0,
        'pph_pasal_25' => 0,
        'pph_pasal_26' => 0,
    ];

    protected $fillable = [
        // 'id',
        'uuid',

        'ap_invoice_id',

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
        'pph_pasal_26',

        'supplier_id',
        'date',
        'invoice_date',
        'supplier_name',

        'pph_pasal_25',

        'number',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',

        'ap_invoice_id' => 'integer',

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
        'pph_pasal_26' => 'double',

        'supplier_id' => 'integer',
        'date' => 'date:Y-m-d',
        'invoice_date' => 'date:Y-m-d',
        'supplier_name' => 'string',

        'pph_pasal_25' => 'double',

        'number' => 'string',
    ];

    public function ap_invoice()
    {
        return $this->belongsTo(ApInvoice::class);
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
