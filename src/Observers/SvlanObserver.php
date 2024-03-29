<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Svlan;
use Ramsey\Uuid\Uuid;

class SvlanObserver
{
    public function creating(Svlan $svlan)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Svlan::where('uuid', $uuid)->exists());
        if (! $svlan->uuid) {
            $svlan->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Svlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Svlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Svlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Svlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Svlan $svlan)
    {
        //
    }
}
