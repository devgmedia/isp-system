<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerRequestKnowFrom extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'pre_customer_request_know_from';

    protected $fillable = [
        // 'id',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pre_customer_requests()
    {
        return $this->hasMany(PreCustomerRequest::class, 'know_from_id');
    }
}
