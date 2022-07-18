<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerEmail extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_email';

    protected $fillable = [
        // 'id',
        'name',
        'customer_id',

        'created_at',
        'updated_at',

        'uuid',

        'verified',
        'verified_at',

        'verification_email_sent_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'uuid' => 'string',

        'verified' => 'boolean',
        'verified_at' => 'datetime',
        
        'verification_email_sent_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
