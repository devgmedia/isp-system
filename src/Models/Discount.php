<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'discount';

    protected $fillable = [
        // 'id',

        'name',
        'effective_date',
        'expired_date',
        'maximum_use',
        'maximum_use_per_product',
        'maximum_use_per_product_additional',
        'maximum_use_per_customer',
        'maximum_use_per_invoice',
        'scheme_id',
        'type_id',
        
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        
        'name' => 'string',
        'effective_date' => 'date:Y-m-d',
        'expired_date' => 'date:Y-m-d',
        'maximum_use' => 'integer',
        'maximum_use_per_product' => 'integer',
        'maximum_use_per_product_additional' => 'integer',
        'maximum_use_per_customer' => 'integer',
        'maximum_use_per_invoice' => 'integer',
        'scheme_id' => 'integer',
        'type_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scheme()
    {
        return $this->belongsTo(DiscountScheme::class);
    }

    public function type()
    {
        return $this->belongsTo(DiscountType::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function product_additionals()
    {
        return $this->hasMany(ProductAdditional::class);
    }
}
