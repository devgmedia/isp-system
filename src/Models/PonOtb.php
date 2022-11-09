<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class PonOtb extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'pon_otb';

    protected $fillable = [
        // 'id',
        'pon_id',
        'otb_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',

        'pon_id' => 'integer',
        'otb_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function otb()
    {
        return $this->belongsTo(Otb::class);
    }

    public function pon()
    {
        return $this->belongsTo(Pon::class);
    }
}
