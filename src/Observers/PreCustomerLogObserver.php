<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\PreCustomerLog;
use app\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PreCustomerLogObserver
{
    public function creating(PreCustomerLog $preCustomerLog)
    {
        $preCustomerLog->date = Carbon::now()->toDateString();
        $preCustomerLog->time = Carbon::now()->toTimeString();

        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);            
            if ($user->employee) {
                $preCustomerLog->caused_by = $user->employee->id;
            }
        }

        if  (!$preCustomerLog->pre_customer_data) $preCustomerLog->pre_customer_data = json_encode([
            'id' => $preCustomerLog->pre_customer_id,
        ]);
    }
    /**q
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerLog  $preCustomerLog
     * @return void
     */
    public function created(PreCustomerLog $preCustomerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerLog  $preCustomerLog
     * @return void
     */
    public function updated(PreCustomerLog $preCustomerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerLog  $preCustomerLog
     * @return void
     */
    public function deleted(PreCustomerLog $preCustomerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerLog  $preCustomerLog
     * @return void
     */
    public function restored(PreCustomerLog $preCustomerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerLog  $preCustomerLog
     * @return void
     */
    public function forceDeleted(PreCustomerLog $preCustomerLog)
    {
        //
    }
}
