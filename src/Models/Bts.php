<?php

namespace Gmedia\IspSystem\Models;

use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\BtsContract;
use Gmedia\IspSystem\Models\BtsInterface;
use Gmedia\IspSystem\Models\BtsItem;
use Illuminate\Database\Eloquent\Model;

class Bts extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'bts';

    protected $fillable = [

        'uuid',
        'name',
        'address',
        'latitude',
        'longitude',
        'elevation',
        'active',
        'branch_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'address' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'elevation' => 'double',
        'active' => 'boolean',
        'branch_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function bts_contract()
    {
        return $this->hasMany(BtsContract::class);
    }

    public function bts_item()
    {
        return $this->hasMany(BtsItem::class);
    }

    public function bts_interface()
    {
        return $this->hasMany(BtsInterface::class);
    }
}
