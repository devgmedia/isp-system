<?php

namespace Gmedia\IspSystem\Models;

use Gmedia\IspSystem\Models\Discount;
use Gmedia\IspSystem\Models\ProductAdditional;
use Illuminate\Database\Eloquent\Model;

class ProductAdditionalDiscount extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'product_additional_discount';

    protected $fillable = [
        // 'id',
        'product_additional_id',
        'discount_id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'product_additional_id' => 'integer',
        'discount_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function product_additional()
    {
        return $this->belongsTo(ProductAdditional::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
