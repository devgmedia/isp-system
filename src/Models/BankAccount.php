<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = 'bank_account';

    protected $fillable = [
        'regional_id',
        'name',
        'bank',
        'place',
        'number',
    ];
}
