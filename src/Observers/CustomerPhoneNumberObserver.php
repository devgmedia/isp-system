<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CustomerPhoneNumber;
use Ramsey\Uuid\Uuid;

class CustomerPhoneNumberObserver
{
    public function creating(CustomerPhoneNumber $customerPhoneNumber)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (CustomerPhoneNumber::where('uuid', $uuid)->exists());
        if (! $customerPhoneNumber->uuid) {
            $customerPhoneNumber->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(CustomerPhoneNumber $customerPhoneNumber)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(CustomerPhoneNumber $customerPhoneNumber)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(CustomerPhoneNumber $customerPhoneNumber)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(CustomerPhoneNumber $customerPhoneNumber)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CustomerPhoneNumber $customerPhoneNumber)
    {
        //
    }
}
