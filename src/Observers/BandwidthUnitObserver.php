<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\BandwidthUnit;
use Ramsey\Uuid\Uuid;

class BandwidthUnitObserver
{
    public function creating(BandwidthUnit $bandwidth_type)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (BandwidthUnit::where('uuid', $uuid)->exists());
        if (!$bandwidth_type->uuid) $bandwidth_type->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\BandwidthUnit  $bandwidth_type
     * @return void
     */
    public function created(BandwidthUnit $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\BandwidthUnit  $bandwidth_type
     * @return void
     */
    public function updated(BandwidthUnit $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\BandwidthUnit  $bandwidth_type
     * @return void
     */
    public function deleted(BandwidthUnit $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\BandwidthUnit  $bandwidth_type
     * @return void
     */
    public function restored(BandwidthUnit $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\BandwidthUnit  $bandwidth_type
     * @return void
     */
    public function forceDeleted(BandwidthUnit $bandwidth_type)
    {
        //
    }
}
