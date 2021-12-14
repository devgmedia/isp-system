<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArInvoiceDetail extends Model
{
    use SoftDeletes;

    protected $table = 'ar_invoice_detail';

    protected $fillable = [
        'ar_invoice_customer_id',
        'product_id',

        'discount',
        'price',
        'subtotal',

        'note',
        'custom_product',
        'custom_additional'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get the product that owns the ArInvoiceDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get all of the additional for the ArInvoiceDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function additional()
    {
        return $this->hasMany(ArInvoiceDetailProductAdditional::class, 'ar_invoice_detail_id', 'id')
            ->whereNull('deleted_at')
            ->with('product_additional');
    }
}
