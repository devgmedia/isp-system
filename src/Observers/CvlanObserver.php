<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Cvlan;
use Ramsey\Uuid\Uuid;

class CvlanObserver
{
    public function creating(Cvlan $svlan)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Cvlan::where('uuid', $uuid)->exists());
        if (! $svlan->uuid) {
            $svlan->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Cvlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Cvlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Cvlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Cvlan $svlan)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Cvlan $svlan)
    {
        //
    }
}
