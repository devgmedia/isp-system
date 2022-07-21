<?php

namespace Gmedia\IspSystem\Models;

use App\Models\Branch as BranchModel;
use App\Models\PurchaseOrderItem as PurchaseOrderItemModel;
use App\Models\PurchaseOrderItemBoq as PurchaseOrderItemBoqModel;
use App\Models\PurchaseOrderItemRab as PurchaseOrderItemRabModel;
use App\Models\Supplier as SupplierModel;
use App\User as UserModel;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $connection = 'isp_system';

    protected $table = 'purchase_order';

    protected $fillable = [
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
        'accounting_division_category_id',
        'journal_project_id',
        'dp',
        'pelunasan',
    ];

    protected $hidden = [];

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

    public function purchase_order_item_boq()
    {
        return $this->hasMany(PurchaseOrderItemBoqModel::class);
    }

    public function purchase_order_item_rab()
    {
        return $this->hasMany(PurchaseOrderItemRabModel::class);
    }
}
