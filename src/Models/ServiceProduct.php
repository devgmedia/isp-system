<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProduct extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'service_product';

    protected $fillable = [
        // 'id',
        'uuid',
        'service_id',
        'product_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'service_id' => 'integer',
        'product_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
