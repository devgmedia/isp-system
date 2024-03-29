<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\District;
use Ramsey\Uuid\Uuid;

class DistrictObserver
{
    public function creating(District $district)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (District::where('uuid', $uuid)->exists());
        if (! $district->uuid) {
            $district->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(District $district)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(District $district)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(District $district)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(District $district)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(District $district)
    {
        //
    }
}
