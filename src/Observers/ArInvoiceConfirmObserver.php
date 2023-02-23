<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Gmedia\IspSystem\Models\ArInvoiceConfirm;
use Illuminate\Support\Facades\Auth;

class ArInvoiceConfirmObserver
{
    public function creating(ArInvoiceConfirm $arInvoiceConfirm)
    {
        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);
            if ($user->employee) {
                $arInvoiceConfirm->submit_by = $user->employee->id;
            }
        }
    }

    /**q
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceConfirm  $arInvoiceConfirm
     * @return void
     */
    public function created(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @return void
     */
    public function updated(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @return void
     */
    public function deleted(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @return void
     */
    public function restored(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }
}
