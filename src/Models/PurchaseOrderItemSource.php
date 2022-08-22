<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

// use Gmedia\IspSystem\Models\PurchaseOrderItem as PurchaseOrderItemModel;

class PurchaseOrderItemSource extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'purchase_order_item_source';

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

    // public function purchase_order_item()
    // {
    //     return $this->belongsTo(PurchaseOrderItemModel::class);
    // }
}
