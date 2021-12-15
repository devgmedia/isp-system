<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArInvoiceCustomerV2 extends Model
{
    protected $connection = 'isp_system';

    use SoftDeletes;

    protected $table = 'ar_invoice_customer_v2';

    protected $fillable = [
        'customer_id',
        'ar_invoice_id',
        'note'
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get all of the details for the ArInvoiceCustomerV2
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(ArInvoiceDetail::class, 'ar_invoice_customer_id', 'id')->whereNull('deleted_at');
    }

    /**
     * Get the customer that owns the ArInvoiceCustomerV2
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
