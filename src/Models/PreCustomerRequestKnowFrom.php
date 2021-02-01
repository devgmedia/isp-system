<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerRequestKnowFrom extends Model
{
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

    public function pre_customer_request()
    {
        return $this->hasMany(PreCustomerRequest::class,'know_from_id');
    }
}