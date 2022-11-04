<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\PreCustomerProspective;
// models
use Ramsey\Uuid\Uuid;

class PreCustomerProspectiveObserver
{
    public function creating(PreCustomerProspective $precustomer_customer)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (PreCustomerProspective::where('uuid', $uuid)->exists());

        $precustomer_customer->uuid = $uuid;
    }

    /**
     * Handle the Precustomer "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomer  $precustomer_customer
     * @return void
     */
    public function created(PreCustomerProspective $precustomer_customer)
    {
        //
    }

    /**
     * Handle the Precustomer "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomer  $precustomer_customer
     * @return void
     */
    public function updated(PreCustomerProspective $precustomer_customer)
    {
        //
    }

    /**
     * Handle the Precustomer "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomer  $precustomer_customer
     * @return void
     */
    public function deleted(PreCustomerProspective $precustomer_customer)
    {
        //
    }

    /**
     * Handle the Precustomer "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomer  $precustomer_customer
     * @return void
     */
    public function restored(PreCustomerProspective $precustomer_customer)
    {
        //
    }

    /**
     * Handle the Precustomer "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomer  $precustomer_customer
     * @return void
     */
    public function forceDeleted(PreCustomerProspective $precustomer_customer)
    {
        //
    }
}
