<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PreCustomerHasTag extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'pre_customer_has_tag';

    protected $fillable = [
        // 'id',
        'pre_customer_id',
        'tag_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'pre_customer_id' => 'integer',
        'tag_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
