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

        'expiration_date',
        'purchase_barcodes', 
        'from_ownership_bts_id',
        'from_ownership_branch_id',
        'from_ownership_regional_id',
        'from_ownership_company_id',
        'from_ownership_customer_id',
        'from_ownership_employee_id',  
        'from_location_bts_id',
        'from_location_branch_id',
        'from_location_regional_id',
        'from_location_company_id',
        'from_location_customer_id',
        'from_location_employee_id',  
        'item_class_id',
        'purchase_request_number',
        'purchase_order_number',
        'item_type_id',
        'note', 
        'long_warranty',
        'long_expiration', 
        'item_condition_id',
        'item_condition_category_id', 
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
 
    //     'from_ownership_branch_id'  => 'integer',
    //     'from_ownership_regional_id'  => 'integer',
    //     'from_ownership_company_id'  => 'integer',
    //     'from_ownership_customer_id'  => 'integer',
    //     'from_ownership_employee_id'  => 'integer',
 
    //     'from_location_branch_id'  => 'integer',
    //     'from_location_regional_id'  => 'integer',
    //     'from_location_company_id'  => 'integer',
    //     'from_location_customer_id'  => 'integer',
    //     'from_location_employee_id'  => 'integer',

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
}
