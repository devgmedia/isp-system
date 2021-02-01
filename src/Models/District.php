<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use  GMedia\IspSystem\Models\Province;
use  GMedia\IspSystem\Models\SubDistrict;

class District extends Model
{
    protected $table = 'district';

    protected $fillable = [
        // 'id',
        'name',
        'province_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'province_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function sub_districts()
    {
        return $this->hasMany(SubDistrict::class);
    }
}
