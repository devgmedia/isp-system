<?php

namespace Gmedia\IspSystem\Models;

use App\User as UserModel;
use Illuminate\Database\Eloquent\Model;

class ItemMovementList extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'item_movement_list';

    protected $fillable = [
        // 'id',

        'movement_id',
        'item_id',
        'brand_id',
        'brand_product_id',

        'from_condition_category_id',

        'to_condition_category_id',

        'from_movement_category_id',

        'to_movement_category_id',

        'from_ownership_bts_id',
        'from_ownership_branch_id',
        'from_ownership_regional_id',
        'from_ownership_company_id',
        'from_ownership_customer_id',
        'from_ownership_employee_id',

        'to_ownership_bts_id',
        'to_ownership_branch_id',
        'to_ownership_regional_id',
        'to_ownership_company_id',
        'to_ownership_customer_id',
        'to_ownership_employee_id',

        'from_location_bts_id',
        'from_location_branch_id',
        'from_location_regional_id',
        'from_location_company_id',
        'from_location_customer_id',
        'from_location_employee_id',

        'to_location_bts_id',
        'to_location_branch_id',
        'to_location_regional_id',
        'to_location_company_id',
        'to_location_customer_id',
        'to_location_employee_id',

        'created_at',
        'updated_at',

        'to_item_class_id',
        'to_pic',

        'from_item_class_id',
        'from_pic',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'date' => 'integer',
        'time' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // public function item()
    // {
    //     return $this->belongsTo(Item::class);
    // }

    public function creator()
    {
        return $this->belongsTo(UserModel::class, 'created_by');
    }
}
