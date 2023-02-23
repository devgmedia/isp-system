<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Isp;
use Ramsey\Uuid\Uuid;

class IspObserver
{
    public function creating(Isp $isp)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Isp::where('uuid', $uuid)->exists());
        if (! $isp->uuid) {
            $isp->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Isp $isp)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Isp $isp)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Isp $isp)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Isp $isp)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Isp $isp)
    {
        //
    }
}
