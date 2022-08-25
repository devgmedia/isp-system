<?php

namespace Gmedia\IspSystem\Models;

use Gmedia\IspSystem\Models\BandwidthType;
use Gmedia\IspSystem\Models\BandwidthUnit;
use Illuminate\Database\Eloquent\Model;

class BtsInterface extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'bts_interface';

    protected $fillable = [
        'bts_id',
        'bandwidth',
        'bandwidth_unit_id',
        'bandwidth_type_id',

    ];

    protected $casts = [
        'bts_id' => 'integer',
        'bandwidth' => 'integer',
        'bandwidth_unit_id' => 'integer',
        'bandwidth_type_id' => 'integer',
    ];

    public function bandwidth_unit()
    {
        return $this->belongsTo(BandwidthUnit::class);
    }

    public function bandwidth_type()
    {
        return $this->belongsTo(BandwidthType::class);
    }
}
