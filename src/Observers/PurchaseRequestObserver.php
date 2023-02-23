<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Branch as BranchModel;
use Gmedia\IspSystem\Models\PurchaseRequest;
use Ramsey\Uuid\Uuid;

class PurchaseRequestObserver
{
    public function creating(PurchaseRequest $purchaseRequest)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (PurchaseRequest::where('uuid', $uuid)->exists());
        if (! $purchaseRequest->uuid) {
            $purchaseRequest->uuid = $uuid;
        }

        $date = $purchaseRequest->date;
        $branch_id = $purchaseRequest->branch_id;
        $first_date = date('Y-m-', strtotime($date)).'01';
        $last_date = date('Y-m-t', strtotime($first_date));

        $latest = $purchaseRequest->where('date', '>=', $first_date)
            ->where('date', '<=', $last_date)
            ->where('branch_id', $branch_id)
            ->latest()
            ->first();

        $latest_number = ! empty($latest) ? $latest->number : 0;

        $urut_arr = explode('/', $latest_number);
        $urut = $urut_arr[count($urut_arr) - 1];
        $no = sprintf('%04d', $urut + 1);

        // get branch code
        $branch_code = BranchModel::find($branch_id)->code;

        $code = 'PR/';
        $number = $code.$branch_code.'/'.date('my', strtotime($date)).'/'.$no;
        // end generate no pr

        $purchaseRequest->number = $number;
    }

    /**
     * Handle the purchase request "created" event.
     *
     * @return void
     */
    public function created(PurchaseRequest $purchaseRequest)
    {
        //
    }

    /**
     * Handle the purchase request "updated" event.
     *
     * @return void
     */
    public function updated(PurchaseRequest $purchaseRequest)
    {
        //
    }

    /**
     * Handle the purchase request "deleted" event.
     *
     * @return void
     */
    public function deleted(PurchaseRequest $purchaseRequest)
    {
        //
    }

    /**
     * Handle the purchase request "restored" event.
     *
     * @return void
     */
    public function restored(PurchaseRequest $purchaseRequest)
    {
        //
    }

    /**
     * Handle the purchase request "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(PurchaseRequest $purchaseRequest)
    {
        //
    }
}
