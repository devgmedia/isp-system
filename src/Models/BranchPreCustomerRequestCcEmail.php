<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class BranchPreCustomerRequestCcEmail extends Model
{
    protected $table = 'branch_pre_customer_request_cc_email';

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
