<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class SpmPaymentMethod extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'spm_payment_method';

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
