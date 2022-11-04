<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ArInvoiceConfirm;
use app\Models\User;
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
     * @param  \Gmedia\IspSystem\Models\ArInvoiceConfirm  $arInvoiceConfirm
     * @return void
     */
    public function updated(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceConfirm  $arInvoiceConfirm
     * @return void
     */
    public function deleted(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceConfirm  $arInvoiceConfirm
     * @return void
     */
    public function restored(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceConfirm  $arInvoiceConfirm
     * @return void
     */
    public function forceDeleted(ArInvoiceConfirm $arInvoiceConfirm)
    {
        //
    }
}
