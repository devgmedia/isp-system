<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerProductBillingEmail extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_product_billing_email';

    protected $fillable = [
        // 'id',
        'name',
        'pre_customer_product_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'pre_customer_product_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer_product()
    {
        return $this->belongsTo(PreCustomerProduct::class);
    }
}
