<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Province;
use App\Models\SubDistrict;

class District extends Model
{
    protected $connection = 'isp_system';
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

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
