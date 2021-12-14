<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    protected $table = 'customer_category';

    protected $fillable = [

        'name', 
        
        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
 
        'name' => 'string', 

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];    
}
