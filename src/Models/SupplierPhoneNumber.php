<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPhoneNumber extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'supplier_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'supplier_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'supplier_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
