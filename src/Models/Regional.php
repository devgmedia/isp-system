<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'regional';

    protected $fillable = [
        // 'id',
        'name',
        'code',
        'company_id',

        'created_at',
        'updated_at',

        'address',
        'postal_code',
        'phone_number',
        'fax',
        'email',

        'spm_finance_is_active',
        'spm_finance_pic',
        'spm_finance_pic_email',

        'spm_general_manager_is_active',
        'spm_general_manager_pic',
        'spm_general_manager_pic_email',

        'spm_director_is_active',
        'spm_director_pic',
        'spm_director_pic_email',

        'supplier_verification_pic',
        'supplier_verification_pic_email',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'company_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'address' => 'string',
        'postal_code' => 'string',
        'phone_number' => 'string',
        'fax' => 'string',
        'email' => 'string',

        'spm_finance_is_active' => 'boolean',
        'spm_finance_pic' => 'string',
        'spm_finance_pic_email' => 'string',

        'spm_general_manager_is_active' => 'boolean',
        'spm_general_manager_pic' => 'string',
        'spm_general_manager_pic_email' => 'string',

        'spm_director_is_active' => 'boolean',
        'spm_director_pic' => 'string',
        'spm_director_pic_email' => 'string',

        'supplier_verification_pic' => 'string',
        'supplier_verification_pic_email' => 'string',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
