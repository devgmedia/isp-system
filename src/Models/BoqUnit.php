<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class BoqUnit extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'boq_unit';

    protected $fillable = [

        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'purchasing_price' => 'integer',
        'marketing_price' => 'integer',
        'margin_price' => 'integer',
        'boq_id' => 'integer',
        'brand_id' => 'integer',
        'brand_product_id' => 'integer',
        'supplier_id' => 'integer',
        'sales_lent' => 'boolean',
        'sales_buy' => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
