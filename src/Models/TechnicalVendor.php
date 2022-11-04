<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalVendor extends Model
{
    protected $connection = 'isp_system';
    
    protected $table = 'technical_vendor';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',
        'supplier_id',
        'auto_installation_retail',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name'  => 'string',
        'supplier_id'  => 'integer',
        'auto_installation_retail'  => 'boolean',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
