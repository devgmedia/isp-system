<?php

namespace Gmedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProductInstallationAssignee extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'customer_product_installation_assignee';

    protected $fillable = [
        // 'id',
        'customer_product_id',
        'employee_id',

        'created_at',
        'updated_at',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'customer_product_id' => 'integer',
        'employee_id' => 'integer',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer_product()
    {
        return $this->belongsTo(CustomerProduct::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
