<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRouterOs extends Model
{
    protected $table = 'product_router_os';

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

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
