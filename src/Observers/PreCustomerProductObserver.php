<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Facades\Customer;
use Gmedia\IspSystem\Facades\Radius;
use Gmedia\IspSystem\Models\PreCustomerProduct;

class PreCustomerProductObserver
{
    public function creating(PreCustomerProduct $preCustomerProduct)
    {        // retail_status
        $preCustomerProduct->retail_status = 'pending';
        // sid
        if (! $preCustomerProduct->sid) {
            $preCustomerProduct->sid = Customer::generateSid(null, $preCustomerProduct->pre_customer);
        }

        // radius
        if ($preCustomerProduct->product) {
            $radius_username = $preCustomerProduct->sid.$preCustomerProduct->product->radius_username_suffix;
            $radius_password = $preCustomerProduct->product->radius_password_prefix.$preCustomerProduct->sid;
        } else {
            $radius_username = $preCustomerProduct->sid.'@gmedia.net.id';
            $radius_password = 'pass4'.$preCustomerProduct->sid;
        }

        if (! $preCustomerProduct->radius_username) {
            $preCustomerProduct->radius_username = $radius_username;
        }
        if (! $preCustomerProduct->radius_password) {
            $preCustomerProduct->radius_password = $radius_password;
        }

        Radius::createUser($radius_username, $radius_password);
    }

    /**
     * Handle the customer product "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProduct  $preCustomerProduct
     * @return void
     */
    public function created(PreCustomerProduct $preCustomerProduct)
    {
        //
    }

    /**
     * Handle the customer product "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProduct  $preCustomerProduct
     * @return void
     */
    public function updated(PreCustomerProduct $preCustomerProduct)
    {
        //
    }

    /**
     * Handle the customer product "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProduct  $preCustomerProduct
     * @return void
     */
    public function deleted(PreCustomerProduct $preCustomerProduct)
    {
        //
    }

    /**
     * Handle the customer product "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProduct  $preCustomerProduct
     * @return void
     */
    public function restored(PreCustomerProduct $preCustomerProduct)
    {
        //
    }

    /**
     * Handle the customer product "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\PreCustomerProduct  $preCustomerProduct
     * @return void
     */
    public function forceDeleted(PreCustomerProduct $preCustomerProduct)
    {
        //
    }
}
