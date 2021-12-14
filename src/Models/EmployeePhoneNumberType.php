<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeePhoneNumberType extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'employee_phone_number_type';

    protected $fillable = [
        // 'id',
        'name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
