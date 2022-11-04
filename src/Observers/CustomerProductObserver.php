<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Facades\Customer;
use Gmedia\IspSystem\Facades\Radius;
use Gmedia\IspSystem\Models\CustomerProduct;
use Ramsey\Uuid\Uuid;

class CustomerProductObserver
{
    public function creating(CustomerProduct $customerProduct)
    {
        // sid
        if (! $customerProduct->sid) {
            $customerProduct->sid = Customer::generateSid($customerProduct->customer);
        }

        // radius
        if ($customerProduct->product) {
            $radius_username = $customerProduct->sid.$customerProduct->product->radius_username_suffix;
            $radius_password = $customerProduct->product->radius_password_prefix.$customerProduct->sid;
        } else {
            $radius_username = $customerProduct->sid.'@gmedia.net.id';
            $radius_password = 'pass4'.$customerProduct->sid;
        }

        if (! $customerProduct->radius_username) {
            $customerProduct->radius_username = $radius_username;
        }
        if (! $customerProduct->radius_password) {
            $customerProduct->radius_password = $radius_password;
        }

        Radius::createUser($radius_username, $radius_password);

        // uuid
        if (! $customerProduct->uuid) {
            $uuid = null;

            do {
                $uuid = Uuid::uuid4();
            } while (CustomerProduct::where('uuid', $uuid)->exists());

            $customerProduct->uuid = $uuid;
        }
    }

    /**
     * Handle the customer product "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProduct  $customerProduct
     * @return void
     */
    public function created(CustomerProduct $customerProduct)
    {
        //
    }

    /**
     * Handle the customer product "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProduct  $customerProduct
     * @return void
     */
    public function updated(CustomerProduct $customerProduct)
    {
        //
    }

    /**
     * Handle the customer product "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProduct  $customerProduct
     * @return void
     */
    public function deleted(CustomerProduct $customerProduct)
    {
        //
    }

    /**
     * Handle the customer product "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProduct  $customerProduct
     * @return void
     */
    public function restored(CustomerProduct $customerProduct)
    {
        //
    }

    /**
     * Handle the customer product "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerProduct  $customerProduct
     * @return void
     */
    public function forceDeleted(CustomerProduct $customerProduct)
    {
        //
    }
}
