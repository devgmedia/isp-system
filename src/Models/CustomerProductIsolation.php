<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductIsolation extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_product_isolation';

    protected $fillable = [
        // 'id',
        'registration_date',
        'customer_product_id',

        'start_date',
        'end_date',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'registration_date' => 'date:Y-m-d',
        'customer_product_id' => 'integer',

        'start_date' => 'date:Y-m-d',        
        'end_date' => 'date:Y-m-d',        

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }
}
