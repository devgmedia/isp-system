<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Onu;
use Ramsey\Uuid\Uuid;

class OnuObserver
{
    public function creating(Onu $onu)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Onu::where('uuid', $uuid)->exists());
        if (! $onu->uuid) {
            $onu->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Onu $onu)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Onu $onu)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Onu $onu)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Onu $onu)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Onu $onu)
    {
        //
    }
}
