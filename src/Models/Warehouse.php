<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'warehouse';

    protected $fillable = [
        // 'id',

        'date',
        'time',

        'category_id',
        'district_id',
        'sub_district_id',
        'village_id',
        'address',
        'latitude',
        'longitude',
        'branch_id',
        'regional_id',
        'company_id',
        'customer_id',
        'employee_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'date' => 'date',
        'time' => 'time',
 
        'category_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'branch_id' => 'integer',
        'regional_id' => 'integer',
        'company_id' => 'integer',
        'customer_id' => 'integer',
        'employee_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // public function item()
    // {
    //     return $this->belongsTo(Item::class);
    // }
}
