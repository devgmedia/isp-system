<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRouter extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'product_router';

    protected $fillable = [
        // 'id',
        'host',
        'user',
        'pass',
        'port',
        'product_id',

        'created_at',
        'updated_at',

        'name',
        'os_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'host' => 'string',
        'user' => 'string',
        'pass' => 'string',
        'port' => 'integer',
        'product_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'name' => 'string',
        'os_id' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function os()
    {
        return $this->belongsTo(ProductRouterOs::class);
    }
}
