<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArInvoiceDetailProductAdditional extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'ar_invoice_detail_product_additional';

    protected $fillable = [
        'product_additional_id',
        'ar_invoice_detail_id',
        'price',
        'custom_additional'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the product_additional that owns the ArInvoiceDetailProductAdditional
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product_additional()
    {
        return $this->belongsTo(ProductAdditional::class, 'product_additional_id');
    }
}
