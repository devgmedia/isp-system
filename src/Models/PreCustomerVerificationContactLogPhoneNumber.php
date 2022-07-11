<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerVerificationContactLogPhoneNumber extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_verification_contact_log_phone_number';

    protected $fillable = [
        // 'id',
        'uuid',
        'pre_customer_verification_contact_log_id',
        'pre_customer_phone_number_id',

        'sent',
        'sent_at',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        
        'pre_customer_verification_contact_log_id' => 'integer',
        'pre_customer_phone_number_id' => 'integer',

        'sent' => 'boolean',
        'sent_at' => 'datetime',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer_verification_contact_log()
    {
        return $this->belongsTo(PreCustomerVerificationContactLog::class);
    }

    public function pre_customer_phone_number()
    {
        return $this->belongsTo(PreCustomerPhoneNumber::class);
    }
}
