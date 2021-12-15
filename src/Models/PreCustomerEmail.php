<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerEmail extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_email';

    protected $fillable = [
        // 'id',
        'name',
        'pre_customer_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'pre_customer_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer()
    {
        return $this->belongsTo(PreCustomer::class);
    }
}
