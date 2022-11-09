<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductInstallationPhoto extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'customer_product_installation_photo';

    protected $fillable = [
        // 'id',
        'customer_product_id',
        'filename',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'customer_product_id' => 'integer',
        'filename' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }
}
