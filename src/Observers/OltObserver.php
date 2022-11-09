<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Olt;
use Ramsey\Uuid\Uuid;

class OltObserver
{
    public function creating(Olt $olt)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Olt::where('uuid', $uuid)->exists());
        if (! $olt->uuid) {
            $olt->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Olt  $olt
     * @return void
     */
    public function created(Olt $olt)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Olt  $olt
     * @return void
     */
    public function updated(Olt $olt)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Olt  $olt
     * @return void
     */
    public function deleted(Olt $olt)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Olt  $olt
     * @return void
     */
    public function restored(Olt $olt)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Olt  $olt
     * @return void
     */
    public function forceDeleted(Olt $olt)
    {
        //
    }
}
