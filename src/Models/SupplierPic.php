<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPic extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'supplier_pic';

    protected $fillable = [
        // 'id',
        'name',
        'supplier_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'supplier_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function phone_numbers()
    {
        return $this->hasMany(SupplierPicPhoneNumber::class);
    }
}
