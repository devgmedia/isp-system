<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class JournalHasTag extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'journal_has_tag';

    protected $fillable = [
        // 'id',
        'journal_id',
        'tag_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'journal_id' => 'integer',
        'tag_id' => 'integer',
        
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
