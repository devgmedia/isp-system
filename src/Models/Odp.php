<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Odp extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'odp';

    protected $fillable = [
        // 'id',
        'uuid',
        'name',

        'item_id',
        'olt_id',
        'pon_id',
        'otb_id',
        'odc_id',
        'odc_mini_id',
        'area_id',

        'latitude',
        'longitude',
        'capacity',
        'usage',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',

        'item_id' => 'integer',
        'olt_id' => 'integer',
        'pon_id' => 'integer',
        'otb_id' => 'integer',
        'odc_id' => 'integer',
        'odc_mini_id' => 'integer',
        'area_id' => 'integer',

        'latitude' => 'double',
        'longitude' => 'double',
        'capacity' => 'integer',
        'usage' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function olt()
    {
        return $this->belongsTo(Olt::class);
    }

    public function pon()
    {
        return $this->belongsTo(Pon::class);
    }

    public function otb()
    {
        return $this->belongsTo(Otb::class);
    }

    public function odc()
    {
        return $this->belongsTo(Odc::class);
    }

    public function odc_mini()
    {
        return $this->belongsTo(OdcMini::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
