<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ItemReturnCategory extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'item_return_category';

    protected $fillable = [
        // 'id',
        'name',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        // 'id' => 'integer',
        'name' => 'string', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime', 
    ];

    public function item_return()
    {
        return $this->hasMany(ItemReturn::class);
    }  
}