<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class OdcOdcMini extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'odc_odc_mini';

    protected $fillable = [
        // 'id',
        'odc_mini_id',
        'odc_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'odc_mini_id' => 'integer',
        'odc_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function otb()
    {
        return $this->belongsTo(Otb::class);
    }

    public function odc()
    {
        return $this->hasMany(Odc::class);
    }
}
