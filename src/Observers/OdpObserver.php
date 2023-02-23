<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Odp;
use Ramsey\Uuid\Uuid;

class OdpObserver
{
    public function creating(Odp $odp)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Odp::where('uuid', $uuid)->exists());
        if (! $odp->uuid) {
            $odp->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Odp $odp)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Odp $odp)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Odp $odp)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Odp $odp)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Odp $odp)
    {
        //
    }
}
