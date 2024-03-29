<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\BandwidthType;
use Ramsey\Uuid\Uuid;

class BandwidthTypeObserver
{
    public function creating(BandwidthType $bandwidth_type)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (BandwidthType::where('uuid', $uuid)->exists());
        if (! $bandwidth_type->uuid) {
            $bandwidth_type->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(BandwidthType $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(BandwidthType $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(BandwidthType $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(BandwidthType $bandwidth_type)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(BandwidthType $bandwidth_type)
    {
        //
    }
}
