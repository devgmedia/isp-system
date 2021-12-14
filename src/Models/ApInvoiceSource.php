<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ApInvoiceSource extends Model
{
    protected $table = 'ap_invoice_source';

    protected $fillable = [
        // 'id',

        'name',

        'created_at',
        'updated_at',

        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'name' => 'string',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'uuid' => 'string',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
}
