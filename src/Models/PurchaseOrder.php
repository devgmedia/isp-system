<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;
use App\User as UserModel;
use App\Models\Supplier as SupplierModel;
use App\Models\Branch as BranchModel;
use App\Models\PurchaseOrderItem as PurchaseOrderItemModel;

class PurchaseOrder extends Model
{
    protected $connection = 'isp_system';
    protected $table = 'purchase_order';

    protected $fillable = [
        // 'id',
        // 'name',
        'number',
        'date',
        'about',
        'created_by',
        'created_name',
        'created_date',
        'finance_approved_by',
        'finance_approved_name',
        'finance_approved_date',
        'director_approved_by',
        'director_approved_name',
        'director_approved_date',
        'total',
        // 'source_id',
        'branch_id',
        'created_at',
        'updated_at',
        'supplier_id',
        'approval_token',
        'sub_department_id',
        'department_id',
        'division_id',
        'finance_approval_request_date',
        'director_approval_request_date',
        'term_of_payment_date',
        'shipping_estimates',
        'currency_id', 
        'diskon',
        'ppn',
        'payment_method_id',
        'shipping_address_id',
        'term_of_payment_id',
        'term_of_delivery_id',
        'term_of_payment_description',
        'offer_document',
        'purchase_request_id',
        'uuid',
    ];

    protected $hidden = [];

    // protected $casts = [
    //     'id' => 'integer',
    //     'name'  => 'string',
    //     'number'    => 'string',
    //     'date' => 'date',
    //     'about' => 'string',
    //     'created_by' => 'integer',
    //     'created_name' => 'string',
    //     'created_date' => 'date',
    //     'finance_approved_by' => 'integer',
    //     'finance_approved_name' => 'string',
    //     'finance_approved_date' => 'date',
    //     'director_approved_by' => 'integer',
    //     'director_approved_name' => 'string',
    //     'director_approved_date' => 'date',
    //     'total' => 'double',
    //     'branch_id' => 'integer',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    //     'supplier_id' => 'integer',
    //     'approval_token' => 'string',
    //     'sub_department_id' => 'integer',
    //     'department_id' => 'integer',
    //     'division_id' => 'integer',
    //     'finance_approval_request_date' => 'date',
    //     'director_approval_request_date' => 'date',
    //     'term_of_payment_date'=> 'date',
    //     'shipping_estimates'=> 'date',
    //     'currency_id'=> 'integer',
    //     'payment_method_id'=> 'integer',
    //     'shipping_address_id'=> 'integer',
    //     'term_of_payment_id'=> 'integer',
    //     'term_of_delivery_id'=> 'integer',
    //     'term_of_payment_description'=> 'string',
    // ];
    
    public function branch()
    {
        return $this->belongsTo(BranchModel::class);
    }

    public function creator()
    {
        return $this->belongsTo(UserModel::class, 'created_by');
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }

    public function finance_approved()
    {
        return $this->belongsTo(UserModel::class, 'finance_approved_by');
    }

    public function director_approved()
    {
        return $this->belongsTo(UserModel::class, 'director_approved_by');
    }

    public function purchase_order_item()
    {
        return $this->hasMany(PurchaseOrderItemModel::class);
    }
    

}
