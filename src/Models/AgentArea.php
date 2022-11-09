<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class AgentArea extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'agent_area';

    protected $fillable = [
        // 'id',
        'name',

        'province_id',
        'district_id',
        'sub_district_id',
        'village_id',

        'postal_code',
        'branch_id',

        'created_at',
        'updated_at',

        'brand_id',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',

        'province_id' => 'integer',
        'district_id' => 'integer',
        'sub_district_id' => 'integer',
        'village_id' => 'integer',

        'postal_code' => 'string',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'brand_id' => 'integer',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sub_district()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class);
    }
}
