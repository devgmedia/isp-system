<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceWhatsapp extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'service_whatsapp';

    protected $fillable = [
        // 'id',
        'uuid',
        'customer_product_id',

        'template_name',
        'name',

        'message_id',
        'message_status',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'customer_product_id' => 'integer',

        'template_name' => 'string',
        'name' => 'string',

        'message_id' => 'string',
        'message_status' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(CustomerProduct::class, 'customer_product_id');
    }
}
