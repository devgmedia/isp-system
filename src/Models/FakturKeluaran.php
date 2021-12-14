<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class FakturKeluaran extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'faktur_keluaran';

    protected $fillable = [
        // 'id',
        'number',
        'date',
        'masa',
        'type',
        'dpp',
        'ppn',
        'pnbp',
        'customer_id',
        'customer_name',
        'customer_npwp',
        'branch_id',
        'branch_name',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'date' => 'date',
        'masa' => 'string',
        'type' => 'string',
        'dpp' => 'string',
        'ppn' => 'string',
        'pnbp' => 'string',
        'customer_id' => 'integer',
        'customer_name' => 'string',
        'customer_npwp' => 'string',
        'branch_id' => 'integer',
        'branch_name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
