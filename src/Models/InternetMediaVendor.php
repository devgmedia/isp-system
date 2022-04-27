<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class InternetMediaVendor extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'internet_media_vendor';

    protected $fillable = [
        // 'id',
        'name',
        'uuid',

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
