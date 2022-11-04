<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CustomerProductDiscount;
use Carbon\Carbon;

class CustomerProductDiscountObserver
{
    public function creating(CustomerProductDiscount $customerProductDiscount)
    {
        // 
    }
    /**
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductDiscount  $customerProductDiscount
     * @return void
     */
    public function created(CustomerProductDiscount $customerProductDiscount)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductDiscount  $customerProductDiscount
     * @return void
     */
    public function updated(CustomerProductDiscount $customerProductDiscount)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductDiscount  $customerProductDiscount
     * @return void
     */
    public function deleted(CustomerProductDiscount $customerProductDiscount)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductDiscount  $customerProductDiscount
     * @return void
     */
    public function restored(CustomerProductDiscount $customerProductDiscount)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProductDiscount  $customerProductDiscount
     * @return void
     */
    public function forceDeleted(CustomerProductDiscount $customerProductDiscount)
    {
        //
    }
}
