<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'bank_account';

    protected $fillable = [
        'regional_id',
        'name',
        'bank',
        'place',
        'number',
    ];
}
