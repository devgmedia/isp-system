<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\BandwidthUnit;
use App\Models\BandwidthType;

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
