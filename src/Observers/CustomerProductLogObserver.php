<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Carbon\Carbon;
use Gmedia\IspSystem\Models\CustomerProductLog;
use Illuminate\Support\Facades\Auth;

class CustomerProductLogObserver
{
    public function creating(CustomerProductLog $customerProductLog)
    {
        $customerProductLog->date = Carbon::now()->toDateString();
        $customerProductLog->time = Carbon::now()->toTimeString();

        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);
            if ($user->employee) {
                $customerProductLog->caused_by = $user->employee->id;
            }
        }

        if (! $customerProductLog->customer_product_data) {
            $customerProductLog->customer_product_data = json_encode([
                'id' => $customerProductLog->customer_product_id,
            ]);
        }
    }

    /**q
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductLog  $customerProductLog
     * @return void
     */
    public function created(CustomerProductLog $customerProductLog)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @return void
     */
    public function updated(CustomerProductLog $customerProductLog)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @return void
     */
    public function deleted(CustomerProductLog $customerProductLog)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @return void
     */
    public function restored(CustomerProductLog $customerProductLog)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CustomerProductLog $customerProductLog)
    {
        //
    }
}
