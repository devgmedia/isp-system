<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerProductBillingPhoneNumber extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_product_billing_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'pre_customer_product_id',
        'whatsapp',
        'telegram',
        'home',
        'office',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'pre_customer_product_id' => 'integer',
        'whatsapp' => 'boolean',
        'telegram' => 'boolean',
        'home' => 'boolean',
        'office' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer_product()
    {
        return $this->belongsTo(PreCustomerProduct::class);
    }
}
