<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'item';

    protected $fillable = [
        // 'id',

        'number',
        'brand_id',
        'brand_product_id',
        'name',
        'packs_quantity',
        'packs_unit_id',
        'mac_address',
        'purchase_price',
        'date_of_purchase',
        'invoice_item_id',
        'invoice_number',
        'serial_number',
        'supplier_id',
        'branch_id',
        'created_at',
        'updated_at',
        'uuid',
        'warranty_end_date',

        'lifetime_end_date',
        'purchase_barcodes',
        'ownership_bts_id',
        'ownership_branch_id',
        'ownership_regional_id',
        'ownership_company_id',
        'ownership_customer_id',
        'ownership_employee_id',
        'location_bts_id',
        'location_branch_id',
        'location_regional_id',
        'location_company_id',
        'location_customer_id',
        'location_employee_id',
        'item_class_id',
        'purchase_request_number',
        'purchase_order_number',
        'item_type_id',
        'note',
        'warranty_priod',
        'lifetime_priod',
        'item_condition_id',
        'item_condition_category_id',

        'pic',
        'auction',
        'auction_price',
    ];

    protected $hidden = [];

    // protected $casts = [
    //     'id' => 'integer',

    //     'number' => 'string',
    //     'brand_id' => 'integer',
    //     'brand_product_id' => 'integer',
    //     'name' => 'string',
    //     'mac_address' => 'string',
    //     'purchase_price' => 'string',
    //     'date_of_purchase' => 'date',
    //     'warranty_end_date' => 'date',
    //     'invoice_item_id' => 'integer',
    //     'invoice_number' => 'string',
    //     'serial_number' => 'string',
    //     'supplier_id' => 'integer',
    //     'branch_id' => 'integer',

    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',

    //     'uuid' => 'string',

    //     'ownership_branch_id'  => 'integer',
    //     'ownership_regional_id'  => 'integer',
    //     'ownership_company_id'  => 'integer',
    //     'ownership_customer_id'  => 'integer',
    //     'ownership_employee_id'  => 'integer',

    //     'location_branch_id'  => 'integer',
    //     'location_regional_id'  => 'integer',
    //     'location_company_id'  => 'integer',
    //     'location_customer_id'  => 'integer',
    //     'location_employee_id'  => 'integer',

    //     'item_class_id'  => 'integer',
    //     'purchase_request_number'  => 'integer',
    //     'purchase_order_number'  => 'integer',
    //     'item_type_id'  => 'integer',
    // ];

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

    public function bts()
    {
        return $this->belongsTo(Bts::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function mac_addresses()
    {
        return $this->hasMany(ItemMacAddress::class);
    }

    public function item_quality_control()
    {
        return $this->hasMany(ItemQualityControl::class);
    }

    public function type()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function type_tipe_quality_control()
    {
        return $this->hasMany(ItemTypeQualityControl::class);
    }

    public function item_movement_list()
    {
        return $this->hasMany(ItemMovementList::class);
    }

    public function pic()
    {
        return $this->belongsTo(Spm::class);
    }
}
