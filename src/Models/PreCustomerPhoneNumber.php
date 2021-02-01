<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use  GMedia\IspSystem\Models\PreCustomer;

class PreCustomerPhoneNumber extends Model
{
    protected $table = 'pre_customer_phone_number';

    protected $fillable = [
        'id',
        'number',
        'pre_customer_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'pre_customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
    }
}
