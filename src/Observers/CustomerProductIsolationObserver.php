<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CustomerProductIsolation;

class CustomerProductIsolationObserver
{
    public function creating(CustomerProductIsolation $customerProductIsolation)
    {
        //
    }

    /**
     * Handle the customer product additional "created" event.
     *
     * @return void
     */
    public function created(CustomerProductIsolation $customerProductIsolation)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @return void
     */
    public function updated(CustomerProductIsolation $customerProductIsolation)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @return void
     */
    public function deleted(CustomerProductIsolation $customerProductIsolation)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @return void
     */
    public function restored(CustomerProductIsolation $customerProductIsolation)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CustomerProductIsolation $customerProductIsolation)
    {
        //
    }
}
