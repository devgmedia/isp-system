<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'supplier';

    protected $fillable = [
        // 'id',
        'name',
        'address',

        'created_by',
        'verified_by',
        
        'branch_id',

        'created_at',
        'updated_at',

        'uuid',

        'verified',
        'verified_at',
        'request_verification_at',

        'npwp',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'address' => 'string',

        'created_by' => 'integer',
        'verified_by' => 'integer',

        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'uuid' => 'string',

        'verified' => 'boolean',
        'verified_at' => 'datetime',
        'request_verification_at' => 'datetime',

        'npwp' => 'string',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucfirst($value);
    }

    public function bank_accounts()
    {
        return $this->hasMany(SupplierBankAccount::class);
    }

    public function phone_numbers()
    {
        return $this->hasMany(SupplierPhoneNumber::class);
    }

    public function pics()
    {
        return $this->hasMany(SupplierPic::class);
    }

    public function created_by_ref()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function verified_by_ref()
    {
        return $this->belongsTo(Employee::class, 'verified_by');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
