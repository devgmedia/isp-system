<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerVerificationContactLog extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_verification_contact_log';
    
    protected $fillable = [
        // 'id',
        'uuid',
        'pre_customer_id',
        'number',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'pre_customer_id' => 'integer',
        'number' => 'string',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
    }
}
