<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBankAccount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'supplier_bank_account';

    protected $fillable = [
        // 'id',
        'bank_id',
        'number',
        'on_behalf_of',
        'supplier_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'bank_id' => 'integer',
        'number' => 'string',
        'on_behalf_of' => 'string',
        'supplier_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function setOnBehalfOfAttribute($value)
    {
        $this->attributes['on_behalf_of'] = ucfirst($value);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
