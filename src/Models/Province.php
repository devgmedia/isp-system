<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'province';

    protected $fillable = [
        // 'id',
        'name',
        'uuid',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'name' => 'uuid',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
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
