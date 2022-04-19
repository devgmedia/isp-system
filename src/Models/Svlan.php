<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Svlan extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'svlan';

    protected $fillable = [
        // 'id',
        'uuid',
        'id_svlan',
        'id_cvlan',
        'mgmt_ip',
        'pon_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'id_svlan' => 'integer',
        'id_cvlan' => 'integer',
        'mgmt_ip' => 'integer',
        'pon_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pon()
    {
        return $this->belongsTo(Pon::class);
    }
}
