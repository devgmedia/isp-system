<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use GMedia\IspSystem\Models\SubDepartment;
use GMedia\IspSystem\Models\Department;
use GMedia\IspSystem\Models\Division;
use GMedia\IspSystem\Models\Branch;
use GMedia\IspSystem\Models\Regional;
use GMedia\IspSystem\Models\Company;
use GMedia\IspSystem\Models\Position;
use GMedia\IspSystem\Models\Education;
use GMedia\IspSystem\Models\Religion;
use GMedia\IspSystem\Models\Gender;
use GMedia\IspSystem\Models\BloodType;
use GMedia\IspSystem\Models\MaritalStatus;
use GMedia\IspSystem\Models\EmployeeAddress;
use GMedia\IspSystem\Models\EmployeeBankAccount;
use GMedia\IspSystem\Models\EmployeePhoneNumber;
use App\Models\User;

class Employee extends Model
{
    protected $table = 'employee';

    protected $fillable = [
        // 'id',

        'uuid',
        'name',
        'number',
        'photo',
        'official_photo',
        'active',
        'sub_department_id',
        'department_id',
        'division_id',
        'finance_id',
        'branch_id',
        'regional_id',
        'company_id',
        'position_id',
        'last_education',
        'religion_id',
        'gender_id',
        'blood_type_id',
        'birthplace',
        'birthdate',
        'marital_status_id',
        'number_of_children',
        'hired_date',
        'fired_date',
        'npwp',
        'user_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid' => 'string',
        'name' => 'string',
        'number' => 'string',
        'photo' => 'string',
        'official_photo' => 'string',
        'active' => 'boolean',
        'sub_department_id' => 'integer',
        'department_id' => 'integer',
        'finance_id' => 'integer',
        'division_id' => 'integer',
        'branch_id' => 'integer',
        'regional_id' => 'integer',
        'company_id' => 'integer',
        'position_id' => 'integer',
        'last_education' => 'string',
        'religion_id' => 'integer',
        'gender_id' => 'integer',
        'blood_type_id' => 'integer',
        'birthplace' => 'string',
        'birthdate' => 'date:Y-m-d',
        'marital_status_id' => 'integer',
        'number_of_children' => 'integer',
        'hired_date' => 'date:Y-m-d',
        'fired_date' => 'date:Y-m-d',
        'npwp' => 'string',
        'user_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function sub_department()
    {
        return $this->belongsTo(SubDepartment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function last_education()
    {
        return $this->belongsTo(Education::class, 'last_education');
    }

    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function blood_type()
    {
        return $this->belongsTo(BloodType::class);
    }

    public function marital_status()
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addresses()
    {
        return $this->hasMany(EmployeeAddress::class);
    }

    public function bank_accounts()
    {
        return $this->hasMany(EmployeeBankAccount::class);
    }

    public function phone_numbers()
    {
        return $this->hasMany(EmployeePhoneNumber::class);
    }
}
