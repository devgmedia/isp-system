<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Gmedia\IspSystem\Models\CustomerProductMaintenance;
use Illuminate\Support\Facades\Auth;

class CustomerProductMaintenanceObserver
{
    public function creating(CustomerProductMaintenance $customerProductMaintenance)
    {
        $user_id = Auth::guard('api')->id();
        if ($user_id) {
            $user = User::with('employee')->find($user_id);            
            if ($user->employee) {
                $customerProductMaintenance->created_by = $user->employee->id;
                $customerProductMaintenance->created_name = $user->employee->name;
            }
        }
    }
    /**q
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductMaintenance  $customerProductMaintenance
     * @return void
     */
    public function created(CustomerProductMaintenance $customerProductMaintenance)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductMaintenance  $customerProductMaintenance
     * @return void
     */
    public function updated(CustomerProductMaintenance $customerProductMaintenance)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductMaintenance  $customerProductMaintenance
     * @return void
     */
    public function deleted(CustomerProductMaintenance $customerProductMaintenance)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductMaintenance  $customerProductMaintenance
     * @return void
     */
    public function restored(CustomerProductMaintenance $customerProductMaintenance)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductMaintenance  $customerProductMaintenance
     * @return void
     */
    public function forceDeleted(CustomerProductMaintenance $customerProductMaintenance)
    {
        //
    }
}
