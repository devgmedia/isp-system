<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Facades\Customer;
use Gmedia\IspSystem\Models\PreCustomerProductAdditional;

class PreCustomerProductAdditionalObserver
{
    public function creating(PreCustomerProductAdditional $preCustomerProductAdditional)
    {
        $preCustomerProductAdditional->sid = Customer::generateSidForAdditional(null, $preCustomerProductAdditional->pre_customer_product);
    }

    /**
     * Handle the customer product additional "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProductAdditional  $preCustomerProductAdditional
     * @return void
     */
    public function created(PreCustomerProductAdditional $preCustomerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProductAdditional  $preCustomerProductAdditional
     * @return void
     */
    public function updated(PreCustomerProductAdditional $preCustomerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProductAdditional  $preCustomerProductAdditional
     * @return void
     */
    public function deleted(PreCustomerProductAdditional $preCustomerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProductAdditional  $preCustomerProductAdditional
     * @return void
     */
    public function restored(PreCustomerProductAdditional $preCustomerProductAdditional)
    {
        //
    }

    /**
     * Handle the customer product additional "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProductAdditional  $preCustomerProductAdditional
     * @return void
     */
    public function forceDeleted(PreCustomerProductAdditional $preCustomerProductAdditional)
    {
        //
    }
}
