<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Facades\Customer;
use Gmedia\IspSystem\Models\CustomerProductAdditional;

class CustomerProductAdditionalObserver
{
    public function creating(CustomerProductAdditional $customerProductAdditional)
    {
        $customerProductAdditional->sid = Customer::generateSidForAdditional($customerProductAdditional->customer_product);
    }

    /**
     * Handle the customer product additional "created" event.
     *
     * @return void
     */
    public function created(CustomerProductAdditional $customerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @return void
     */
    public function updated(CustomerProductAdditional $customerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @return void
     */
    public function deleted(CustomerProductAdditional $customerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @return void
     */
    public function restored(CustomerProductAdditional $customerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CustomerProductAdditional $customerProductAdditional)
    {
        //
    }
}
