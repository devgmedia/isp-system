<?php

namespace  GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use  GMedia\IspSystem\Models\Customer;
use  GMedia\IspSystem\Models\Regional;

class Branch extends Model
{
    protected $table = 'branch';

    protected $fillable = [
        // 'id',
        'name',
        'code',
        'timezone',
        'regional_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'timezone' => 'datetime',
        'regional_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function sub_departments()
    {
        return $this->hasMany(SubDepartment::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }
}
