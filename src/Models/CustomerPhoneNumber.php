<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPhoneNumber extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'customer_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'customer_id',

        'created_at',
        'updated_at',

        'whatsapp',
        'telegram',

        'home',
        'office',
        'personal',

        'name',

        'uuid',

        'whatsapp_verified',
        'whatsapp_verified_at',

        'whatsapp_verification_sent_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'whatsapp' => 'boolean',
        'telegram' => 'boolean',

        'home' => 'boolean',
        'office' => 'boolean',
        'personal' => 'boolean',

        'name' => 'string',

        'uuid' => 'string',

        'whatsapp_verified' => 'boolean',
        'whatsapp_verified_at' => 'datetime',

        'whatsapp_verification_sent_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
