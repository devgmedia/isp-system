<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Kasbon;
use Ramsey\Uuid\Uuid;

class KasbonObserver
{
    public function creating(Kasbon $kasbon)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Kasbon::where('uuid', $uuid)->exists());
        if (! $kasbon->uuid) {
            $kasbon->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Kasbon $kasbon)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Kasbon $kasbon)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Kasbon $kasbon)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Kasbon $kasbon)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Kasbon $kasbon)
    {
        //
    }
}
