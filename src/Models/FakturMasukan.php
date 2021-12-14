<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class FakturMasukan extends Model
{
    protected $table = 'faktur_masukan';

    protected $fillable = [
        // 'id',
        'number',
        'branch_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'number' => 'string',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
