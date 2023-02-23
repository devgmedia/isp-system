<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Otb;
use Ramsey\Uuid\Uuid;

class OtbObserver
{
    public function creating(Otb $otb)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Otb::where('uuid', $uuid)->exists());
        if (! $otb->uuid) {
            $otb->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Otb $otb)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Otb $otb)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Otb $otb)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Otb $otb)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Otb $otb)
    {
        //
    }
}
