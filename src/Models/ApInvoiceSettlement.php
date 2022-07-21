<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ApInvoiceSettlement extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'ap_invoice_settlement';

    protected $fillable = [
        // 'id',

        'ap_invoice_id',
        'date',
        'total',

        'branch_id',
        'chart_of_account_title_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'ap_invoice_id' => 'integer',
        'date' => 'date:Y-m-d',
        'total' => 'double',

        'branch_id' => 'integer',
        'chart_of_account_title_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(ApInvoice::class, 'ap_invoice_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function chart_of_account_title()
    {
        return $this->belongsTo(ChartOfAccountTitle::class);
    }
}
