<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductInstallationItem extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_product_installation_item';

    protected $fillable = [
        // 'id',

        'uuid',
        'customer_product_id',
        'item_id',
        'item_status',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'uuid'=> 'string',
        'customer_product_id'=> 'integer',
        'item_id'=> 'integer',
        'item_status'=> 'string',
    ];

    function item()
    {
        return $this->belongsTo(Item::class);
    }

    function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }
}
