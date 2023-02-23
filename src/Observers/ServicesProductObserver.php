<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ServiceProduct;
use Ramsey\Uuid\Uuid;

class ServicesProductObserver
{
    public function creating(ServiceProduct $services_product)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ServiceProduct::where('uuid', $uuid)->exists());
        if (! $services_product->uuid) {
            $services_product->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(ServiceProduct $services_product)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(ServiceProduct $services_product)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(ServiceProduct $services_product)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(ServiceProduct $services_product)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(ServiceProduct $services_product)
    {
        //
    }
}
