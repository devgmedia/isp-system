<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\InternetMediaVendor;
use Ramsey\Uuid\Uuid;

class InternetMediaVendorObserver
{
    public function creating(InternetMediaVendor $internet_media_vendor)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (InternetMediaVendor::where('uuid', $uuid)->exists());
        if (! $internet_media_vendor->uuid) {
            $internet_media_vendor->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(InternetMediaVendor $internet_media_vendor)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(InternetMediaVendor $internet_media_vendor)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(InternetMediaVendor $internet_media_vendor)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(InternetMediaVendor $internet_media_vendor)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(InternetMediaVendor $internet_media_vendor)
    {
        //
    }
}
