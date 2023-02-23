<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Carbon\Carbon;
use Gmedia\IspSystem\Models\CustomerVisitLog;
use Illuminate\Support\Facades\Auth;

class CustomerVisitLogObserver
{
    public function creating(CustomerVisitLog $customerVisitLog)
    {
        $customerVisitLog->date = Carbon::now()->toDateString();
        $customerVisitLog->time = Carbon::now()->toTimeString();

        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);
            if ($user->employee) {
                $customerVisitLog->caused_by = $user->employee->id;
            }
        }

        $customerVisitLog->customer_visit_data = json_encode([
            'id' => $customerVisitLog->customer_visit_id,
        ]);
    }

    /**
     * Handle the customer product additional "created" event.
     *
     * @return void
     */
    public function created(CustomerVisitLog $customerVisitLog)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @return void
     */
    public function updated(CustomerVisitLog $customerVisitLog)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @return void
     */
    public function deleted(CustomerVisitLog $customerVisitLog)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @return void
     */
    public function restored(CustomerVisitLog $customerVisitLog)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CustomerVisitLog $customerVisitLog)
    {
        //
    }
}
