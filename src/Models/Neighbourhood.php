<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Neighbourhood extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'neighbourhood';

    protected $fillable = [
        // 'id',
        'name',
        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',
        'hamlet_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'province_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',
        'hamlet_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function hamlet()
    {
        return $this->belongsTo(Hamlet::class);
    }
}
