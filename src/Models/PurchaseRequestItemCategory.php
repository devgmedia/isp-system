<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItemCategory extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'purchase_request_item_category';

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

    public function purchase_request()
    {
        return $this->belongsTo('App\Models\PurchaseRequest');
    }
}
