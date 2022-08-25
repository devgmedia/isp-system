<?php

namespace Gmedia\IspSystem\Models;

use Gmedia\IspSystem\Models\SubDistrict;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'village';

    protected $fillable = [
        // 'id',
        'name',
        'sub_district_id',
        'postal_code',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'sub_district_id' => 'integer',
        'postal_code' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
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
