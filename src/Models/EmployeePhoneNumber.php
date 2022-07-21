<?php

namespace Gmedia\IspSystem\Models;

use App\Models\Employee;
use App\Models\EmployeePhoneNumberType;
use Illuminate\Database\Eloquent\Model;

class EmployeePhoneNumber extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'employee_phone_number';

    protected $fillable = [
        // 'id',
        'number',
        'type_id',
        'employee_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'type_id' => 'integer',
        'employee_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function type()
    {
        return $this->belongsTo(EmployeePhoneNumberType::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
