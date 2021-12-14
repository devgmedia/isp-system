<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

// models
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Employee;

class CustomerVisit extends Model
{
    protected $table = 'customer_visit';

    protected $fillable = [

        'date',
        'report',
        'customer_id',
        'branch_id',
        'employee_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [

        'date' => 'date:Y-m-d',
        'report' => 'string',
        'customer_id' => 'integer',
        'branch_id' => 'integer',
        'employee_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
