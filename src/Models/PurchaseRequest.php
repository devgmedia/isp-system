<?php

namespace GMedia\IspSystem\Models;

use Illuminate\Database\Eloquent\Model;

use App\User as UserModel;
use App\Models\Branch as BranchModel;
use App\Models\Supplier as SupplierModel;
use App\Models\PurchaseRequestItem as PurchaseRequestItemModel;
use App\Models\SubDepartment as SubDepartmentModel;
use App\Models\Division as DivisionModel;
use App\Models\Department as DepartmentModel;

class PurchaseRequest extends Model
{
    protected $table = 'purchase_request';

    protected $fillable = [
        // 'id',
        'name',
        'number',
        'date',
        'about',
        'created_by',
        'created_date',
        'department_approved_by',
        'department_approved_date',
        'department_approved_name',
        'purchasing_approved_by',
        'purchasing_approved_date',
        'purchasing_approved_name',
        'finance_approved_by',
        'finance_approved_name',
        'finance_approved_date',
        'director_approved_by',
        'director_approved_name',
        'director_approved_date',
        'total',
        'branch_id',
        'sub_department_id',
        'created_at',
        'updated_at',
        
        'supplier_id',
        'currency_id', 
        'payment_method_id',
        'shipping_address_id',
        'shipping_estimates',
        'term_of_delivery_id',
        'term_of_payment_id',
        'term_of_payment_date',
        'term_of_payment_description',
        'offer_document',
        'diskon',
        'ppn',

        'department_id',
        'division_id',
        'created_name',
        'approval_token',
        'department_approval_request_date',
        'purchasing_approval_request_date',
        'finance_approval_request_date',
        'director_approval_request_date',
        'uuid',
    ];

    protected $hidden = [];

    protected $casts = [
        'id' => 'integer',
        'name'  => 'string',
        'number'    => 'string',
        'date' => 'date',
        'about' => 'string',
        'created_by' => 'integer',
        'created_date' => 'date',
        'department_approved_by' => 'integer',
        'department_approved_date' => 'date',
        'department_approved_name' => 'string',
        'purchasing_approved_by' => 'integer',
        'purchasing_approved_date' => 'date',
        'purchasing_approved_name' => 'string',
        'finance_approved_by' => 'integer',
        'finance_approved_name' => 'string',
        'finance_approved_date' => 'date',
        'director_approved_by' => 'integer',
        'director_approved_name' => 'string',
        'director_approved_date' => 'date',
        'total' => 'double',
        'branch_id' => 'integer',
        'sub_department_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'department_id' => 'integer',
        'division_id' => 'integer',
        'created_name' => 'string',
        'approval_token' => 'string',
        'department_approval_request_date' => 'date',
        'purchasing_approval_request_date' => 'date',
        'finance_approval_request_date' => 'date',
        'diractor_approval_request_date' => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchModel::class);
    }

    public function sub_department()
    {
        return $this->belongsTo(SubDepartmentModel::class);
    }

    public function creator()
    {
        return $this->belongsTo(UserModel::class, 'created_by');
    }

    public function department()
    {
        return $this->belongsTo(DepartmentModel::class, 'department_id');
    }

    public function department_approved()
    {
        return $this->belongsTo(UserModel::class, 'department_approved_by');
    }

    public function division()
    {
        return $this->belongsTo(DivisionModel::class, 'division_id');
    }

    public function division_approved()
    {
        return $this->belongsTo(UserModel::class, 'division_approved_by');
    }

    public function purchasing_approved()
    {
        return $this->belongsTo(UserModel::class, 'purchasing_approved_by');
    }

    public function finance_approved()
    {
        return $this->belongsTo(UserModel::class, 'finance_approved_by');
    }

    public function director_approved()
    {
        return $this->belongsTo(UserModel::class, 'director_approved_by');
    }

    public function purchase_request_item()
    {
        return $this->hasMany(PurchaseRequestItemModel::class);
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }
}
