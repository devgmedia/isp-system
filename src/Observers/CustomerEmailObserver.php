<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CustomerEmail;
use Ramsey\Uuid\Uuid;

class CustomerEmailObserver
{
    public function creating(CustomerEmail $customerEmail)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (CustomerEmail::where('uuid', $uuid)->exists());
        if (!$customerEmail->uuid) $customerEmail->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerEmail  $customerEmail
     * @return void
     */
    public function created(CustomerEmail $customerEmail)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerEmail  $customerEmail
     * @return void
     */
    public function updated(CustomerEmail $customerEmail)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerEmail  $customerEmail
     * @return void
     */
    public function deleted(CustomerEmail $customerEmail)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerEmail  $customerEmail
     * @return void
     */
    public function restored(CustomerEmail $customerEmail)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerEmail  $customerEmail
     * @return void
     */
    public function forceDeleted(CustomerEmail $customerEmail)
    {
        //
    }
}
