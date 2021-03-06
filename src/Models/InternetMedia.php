<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class InternetMedia extends Model
{
    protected $table = 'internet_media';

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
