<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $table = 'product_brand';

    protected $fillable = [
        // 'id',
        'name',
        
        'created_at',
        'updated_at',

        'billing_email',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'billing_email' => 'string',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
