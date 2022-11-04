<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Facades\Cid;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Ramsey\Uuid\Uuid;

// models
use app\Models\User as UserModel;
use Gmedia\IspSystem\Models\PreCustomerProspective;

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
