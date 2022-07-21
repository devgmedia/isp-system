<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPicPhoneNumber extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'supplier_pic_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'supplier_pic_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'supplier_pic_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function supplier_pic()
    {
        return $this->belongsTo(SupplierPic::class);
    }
}
