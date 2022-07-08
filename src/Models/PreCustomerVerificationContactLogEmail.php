<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerVerificationContactLogEmail extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_verification_contact_log_email';

    protected $fillable = [
        // 'id',
        'uuid',
        'pre_customer_verification_contact_log_id',
        'pre_customer_email_id',

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
        'pre_customer_email_id' => 'integer',

        'sent' => 'boolean',
        'sent_at' => 'datetime',

        'pre_customer_id' => 'integer',
        'number' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer_verification_contact_log()
    {
        return $this->belongsTo(PreCustomerVerificationContactLog::class);
    }

    public function pre_customer_email()
    {
        return $this->belongsTo(PreCustomerEmail::class);
    }
}
