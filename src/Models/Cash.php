<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table = 'cash';

    protected $fillable = [
        // 'id',

        'name',
        'nominal',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',
        'nominal' => 'double',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
