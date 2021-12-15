<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'item';

    protected $fillable = [
        // 'id',

        'brand_id',
        'brand_product_id',
        'name',
        'mac_address',
        'purchase_price',
        'date_of_purchase',
        'warranty_end_date',
        'invoice_item_id',
        'invoice_number',
        'serial_number',
        'supplier_id',
        'branch_id',
        
        'packs_unit_id',
        'packs_quantity',

        'created_at',
        'updated_at',

        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'brand_id' => 'integer',
        'brand_product_id' => 'integer',
        'name' => 'string',
        'mac_address' => 'string',
        'purchase_price' => 'string',
        'date_of_purchase' => 'date',
        'warranty_end_date' => 'date',
        'invoice_item_id' => 'integer',
        'invoice_number' => 'string',
        'serial_number' => 'string',
        'supplier_id' => 'integer',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'uuid' => 'string',
    ];

    public function brand()
    {
        return $this->belongsTo(ItemBrand::class);
    }

    public function brand_product()
    {
        return $this->belongsTo(ItemBrandProduct::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function mac_addresses()
    {
        return $this->hasMany(ItemMacAddress::class);
    }
}
