<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Province;
use Ramsey\Uuid\Uuid;

class ProvinceObserver
{
    public function creating(Province $province)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Province::where('uuid', $uuid)->exists());
        if (! $province->uuid) {
            $province->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Province $province)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Province $province)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Province $province)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Province $province)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Province $province)
    {
        //
    }
}
