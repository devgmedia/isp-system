<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\PurchaseOrder;
use Gmedia\IspSystem\Models\Branch as BranchModel;
use Ramsey\Uuid\Uuid;

class PurchaseOrderObserver
{
    public function creating(PurchaseOrder $purchaseOrder)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (PurchaseOrder::where('uuid', $uuid)->exists());
        if (!$purchaseOrder->uuid) $purchaseOrder->uuid = $uuid;

        $date = $purchaseOrder->date;
        $branch_id = $purchaseOrder->branch_id;
        $first_date = date('Y-m-', strtotime($date)).'01';
        $last_date = date('Y-m-t', strtotime($first_date));

        $latest = $purchaseOrder->where('date', '>=', $first_date)
        ->where('date', '<=', $last_date)
        ->where('branch_id', $branch_id)
        ->latest()
        ->first();

        $latest_number = !empty($latest) ? $latest->number : 0;

        $urut_arr = explode('/', $latest_number);
        $urut = $urut_arr[count($urut_arr)-1];
        $no = sprintf('%04d', $urut+1);


        // get branch code
        $branch_code = BranchModel::find($branch_id)->code;

        $code = 'PO/';
        $number = $code.$branch_code.'/'.date('my', strtotime($date)).'/'.$no;
        // end generate no pr

        $purchaseOrder->number = $number;
    }
}
