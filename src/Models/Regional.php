<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use GMedia\IspSystem\Models\Company;

class Regional extends Model
{
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
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
