<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Service;
use Ramsey\Uuid\Uuid;

class ServicesObserver
{
    public function creating(Service $services)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Service::where('uuid', $uuid)->exists());
        if (!$services->uuid) $services->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Service  $services
     * @return void
     */
    public function created(Service $services)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Service  $services
     * @return void
     */
    public function updated(Service $services)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Service  $services
     * @return void
     */
    public function deleted(Service $services)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Service  $services
     * @return void
     */
    public function restored(Service $services)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Service  $services
     * @return void
     */
    public function forceDeleted(Service $services)
    {
        //
    }
}
