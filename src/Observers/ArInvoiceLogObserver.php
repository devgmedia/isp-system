<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ArInvoiceLog;
use app\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ArInvoiceLogObserver
{
    public function creating(ArInvoiceLog $arInvoiceLog)
    {
        $arInvoiceLog->date = Carbon::now()->toDateString();
        $arInvoiceLog->time = Carbon::now()->toTimeString();

        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);            
            if ($user->employee) {
                $arInvoiceLog->caused_by = $user->employee->id;
            }
        }

        if (!$arInvoiceLog->ar_invoice_data) $arInvoiceLog->ar_invoice_data = json_encode([
            'id' => $arInvoiceLog->ar_invoice_id,
        ]);
    }
    /**
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceLog  $arInvoiceLog
     * @return void
     */
    public function created(ArInvoiceLog $arInvoiceLog)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceLog  $arInvoiceLog
     * @return void
     */
    public function updated(ArInvoiceLog $arInvoiceLog)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceLog  $arInvoiceLog
     * @return void
     */
    public function deleted(ArInvoiceLog $arInvoiceLog)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceLog  $arInvoiceLog
     * @return void
     */
    public function restored(ArInvoiceLog $arInvoiceLog)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceLog  $arInvoiceLog
     * @return void
     */
    public function forceDeleted(ArInvoiceLog $arInvoiceLog)
    {
        //
    }
}
