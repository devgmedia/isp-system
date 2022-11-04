<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\PreCustomerRequestLog;
use app\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PreCustomerRequestLogObserver
{
    public function creating(PreCustomerRequestLog $preCustomerRequestLog)
    {
        $preCustomerRequestLog->date = Carbon::now()->toDateString();
        $preCustomerRequestLog->time = Carbon::now()->toTimeString();

        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);            
            if ($user->employee) {
                $preCustomerRequestLog->caused_by = $user->employee->id;
            }
        }

        $preCustomerRequestLog->pre_customer_request_data = json_encode([
            'id' => $preCustomerRequestLog->pre_customer_request_id,
        ]);
    }
    /**
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerRequestLog  $preCustomerRequestLog
     * @return void
     */
    public function created(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerRequestLog  $preCustomerRequestLog
     * @return void
     */
    public function updated(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerRequestLog  $preCustomerRequestLog
     * @return void
     */
    public function deleted(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerRequestLog  $preCustomerRequestLog
     * @return void
     */
    public function restored(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerRequestLog  $preCustomerRequestLog
     * @return void
     */
    public function forceDeleted(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }
}
