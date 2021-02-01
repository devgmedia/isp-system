<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use GMedia\IspSystem\Models\Employee;
use GMedia\IspSystem\Models\EmployeeAddressTag;

class EmployeeAddress extends Model
{
    protected $table = 'employee_address';

    protected $fillable = [
        // 'id',
        'name',
        'employee_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'employee_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function tags()
    {
        return $this->belongsToMany(EmployeeAddressTag::class, EmployeeAddressHasTag::class, 'address_id', 'tag_id');
    }
}
