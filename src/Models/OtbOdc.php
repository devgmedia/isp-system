<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class OtbOdc extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'otb_odc';

    protected $fillable = [
        // 'id',
        'otb_id',
        'odc_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'otb_id' => 'integer',
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
