<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAuction extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'item_auction';

    protected $fillable = [
        // 'id',

        'item_id',
        'date_of_auction',
        'auction_price',
        'finance_approved_by',
        'finance_approved_date',
        'finance_approved_name',
        'warehouse_approved_by',
        'warehouse_approved_date',
        'warehouse_approved_name',
        'warehouse_approved_file',
        'created_at',
        'updated_at',
        'created_by',
        'created_name',
    ];

    protected $hidden = [];

    protected $casts = [
        // 'id' => 'integer',

        'item_id' => 'integer',
        'date_of_auction' => 'date',
        'auction_price' => 'integer',
        'finance_approved_by' => 'integer',
        'finance_approved_date' => 'date',
        'finance_approved_name' => 'string',
        'warehouse_approved_by' => 'integer',
        'warehouse_approved_date' => 'date',
        'warehouse_approved_name' => 'string',
        'warehouse_approved_file' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
