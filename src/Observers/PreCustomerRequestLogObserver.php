<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Carbon\Carbon;
use Gmedia\IspSystem\Models\PreCustomerRequestLog;
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
     * @return void
     */
    public function created(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @return void
     */
    public function updated(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @return void
     */
    public function deleted(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @return void
     */
    public function restored(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(PreCustomerRequestLog $preCustomerRequestLog)
    {
        //
    }
}
