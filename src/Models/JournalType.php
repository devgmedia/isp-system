<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class JournalType extends Model
{
    protected $table = 'journal_type';

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
