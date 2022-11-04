<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ArInvoiceEmailReminder;
use app\Models\User;
use Illuminate\Support\Facades\Auth;

class ArInvoiceEmailReminderObserver
{
    public function creating(ArInvoiceEmailReminder $arInvoiceEmailReminder)
    {
        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);            
            if ($user->employee) {
                $arInvoiceEmailReminder->sent_by = $user->employee->id;
            }
        }
    }
    /**q
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceEmailReminder  $arInvoiceEmailReminder
     * @return void
     */
    public function created(ArInvoiceEmailReminder $arInvoiceEmailReminder)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceEmailReminder  $arInvoiceEmailReminder
     * @return void
     */
    public function updated(ArInvoiceEmailReminder $arInvoiceEmailReminder)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceEmailReminder  $arInvoiceEmailReminder
     * @return void
     */
    public function deleted(ArInvoiceEmailReminder $arInvoiceEmailReminder)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceEmailReminder  $arInvoiceEmailReminder
     * @return void
     */
    public function restored(ArInvoiceEmailReminder $arInvoiceEmailReminder)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceEmailReminder  $arInvoiceEmailReminder
     * @return void
     */
    public function forceDeleted(ArInvoiceEmailReminder $arInvoiceEmailReminder)
    {
        //
    }
}
