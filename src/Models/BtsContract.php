<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Bts;

class BtsContract extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'bts_contract';

    protected $fillable = [
       'date',
       'end_date',
       'document',
       'bts_id',
    ];

    protected $casts = [
       'date' => 'date:Y-m-d',
       'end_date' => 'date:Y-m-d',
       'document' => 'string',
       'bts_id' => 'integer',
    ];

    public function Bts(){
        return $this->belongsTo(Bts::class);
    }
}
