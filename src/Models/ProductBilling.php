<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBilling extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'product_billing';

    protected $fillable = [
        // 'id',
        'product_id',

        'email',
        'bank_id',
        'bank_account_number',
        'bank_account_on_behalf_of',
        'receiver',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',

        'email' => 'string',
        'bank_id' => 'integer',
        'bank_account_number' => 'string',
        'bank_account_on_behalf_of' => 'string',
        'receiver' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function receiver_ref()
    {
        return $this->belongsTo(Employee::class, 'receiver');
    }
}
