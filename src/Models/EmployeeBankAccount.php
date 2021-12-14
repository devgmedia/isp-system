<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeBankAccount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'employee_bank_account';

    protected $fillable = [
        // 'id',
        'bank_id',
        'number',
        'on_behalf_of',
        'employee_id',
        
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'bank_id' => 'integer',
        'number' => 'string',
        'on_behalf_of' => 'string',
        'employee_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
