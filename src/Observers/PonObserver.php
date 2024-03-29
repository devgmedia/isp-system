<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Pon;
use Ramsey\Uuid\Uuid;

class PonObserver
{
    public function creating(Pon $pon)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Pon::where('uuid', $uuid)->exists());
        if (! $pon->uuid) {
            $pon->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Pon $pon)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Pon $pon)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Pon $pon)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Pon $pon)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Pon $pon)
    {
        //
    }
}
