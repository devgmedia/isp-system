<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Carbon\Carbon;
use Gmedia\IspSystem\Models\CustomerLog;
use Illuminate\Support\Facades\Auth;

class CustomerLogObserver
{
    public function creating(CustomerLog $customerLog)
    {
        $customerLog->date = Carbon::now()->toDateString();
        $customerLog->time = Carbon::now()->toTimeString();

        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);
            if ($user->employee) {
                $customerLog->caused_by = $user->employee->id;
            }
        }

        if (! $customerLog->customer_data) {
            $customerLog->customer_data = json_encode([
                'id' => $customerLog->customer_id,
            ]);
        }
    }

    /**q
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerLog  $customerLog
     * @return void
     */
    public function created(CustomerLog $customerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @return void
     */
    public function updated(CustomerLog $customerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @return void
     */
    public function deleted(CustomerLog $customerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @return void
     */
    public function restored(CustomerLog $customerLog)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CustomerLog $customerLog)
    {
        //
    }
}
