<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAddressHasTag extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'employee_address_has_tag';

    protected $fillable = [
        // 'id',
        'address_id',
        'tag_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'address_id' => 'integer',
        'tag_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
