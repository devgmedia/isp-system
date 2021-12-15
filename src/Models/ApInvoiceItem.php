<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ApInvoiceItem extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ap_invoice_item';

    protected $fillable = [
        // 'id',

        'ap_invoice_id',
        'po_category_id',
        'name',
        'price',

        'created_at',
        'updated_at',

        'pr_category_id',

        'discount',
        'retention',
        'tax_base',
        'tax',
        'pph_pasal_21',
        'pph_pasal_23',
        'pph_pasal_4_ayat_2',
        'total',
        'total_without_pph',
        'paid_taxes',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'ap_invoice_id' => 'integer',
        'po_category_id' => 'integer',
        'name' => 'string',
        'price' => 'double',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'pr_category_id' => 'integer',

        'discount' => 'double',
        'retention' => 'double',
        'tax_base' => 'double',
        'tax' => 'double',
        'pph_pasal_21' => 'double',
        'pph_pasal_23' => 'double',
        'pph_pasal_4_ayat_2' => 'double',
        'total' => 'double',
        'total_without_pph' => 'double',
        'paid_taxes' => 'double',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function invoice()
    {
        return $this->belongsTo(ApInvoice::class, 'ap_invoice_id');
    }

    public function po_category()
    {
        return $this->belongsTo(ApInvoiceItemPoCategory::class);
    }

    public function pr_category()
    {
        return $this->belongsTo(ApInvoiceItemPrCategory::class);
    }
}
