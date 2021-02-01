<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use  GMedia\IspSystem\Models\District;
use  GMedia\IspSystem\Models\Village;

class SubDistrict extends Model
{
    protected $table = 'sub_district';

    protected $fillable = [
        // 'id',
        'name',
        'district_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'district_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
