<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerPhoneNumber extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'pre_customer_id',
        
        'whatsapp',
        'telegram',
        'home',
        'office',

        'verified',
        'verified_at',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'pre_customer_id' => 'integer',

        'whatsapp' => 'boolean',
        'telegram' => 'boolean',
        'home' => 'boolean',
        'office' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
    }
}
