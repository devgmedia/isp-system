<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReturn extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'item_return';

    protected $fillable = [
        // 'id',

        'name',
        'number_spm',
        'date_of_purchase',
        'date_of_return',
        'purchase_price',
        'brand_id',
        'brand_product_id',
        'item_type_id',
        'item_id',
        'supplier_id',
        'item_return_category_id',
        'return_price',
        'note',
        'created_at',
        'updated_at',
        'created_by',
        'created_name',
        'spm_id',
        'number_invoice',
    ];

    protected $hidden = [];

    protected $casts = [
        // 'id' => 'integer',

        'name' => 'string',
        'brand_id' => 'integer',
        'brand_product_id' => 'integer',
        'uuid' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function brand()
    {
        return $this->belongsTo(ItemBrand::class);
    }

    public function brand_product()
    {
        return $this->belongsTo(ItemBrandProduct::class);
    }

    public function item_return_category()
    {
        return $this->belongsTo(ItemReturnCategory::class);
    }
}
