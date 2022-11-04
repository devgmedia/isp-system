<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalVendorSchedule extends Model
{
    protected $connection = 'isp_system';
    
    protected $table = 'technical_vendor_schedule';

    protected $fillable = [
        // 'id',
        'technical_vendor_id',
        'customer_product_id',
        'odp_id',
        'message',
        'cable_distance',
        'installation_schedule_date',
        'installation_date',
        'installation_status',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'technical_vendor_id' => 'integer',
        'customer_product_id' => 'integer',
        'odp_id' => 'integer',
        'message' => 'string',
        'cable_distance' => 'string',
        'installation_schedule_date' => 'datetime',
        'installation_date' => 'datetime',
        'installation_status' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function odp()
    {
        return $this->belongsTo(Odp::class);
    }

    public function technical_vendor()
    {
        return $this->belongsTo(TechnicalVendor::class);
    }

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }
}
