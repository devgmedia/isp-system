<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CashOpname;
use Ramsey\Uuid\Uuid;

class CashOpnameObserver
{
    public function creating(CashOpname $cashOpname)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (CashOpname::where('uuid', $uuid)->exists());
        if (! $cashOpname->uuid) {
            $cashOpname->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(CashOpname $cashOpname)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(CashOpname $cashOpname)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(CashOpname $cashOpname)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(CashOpname $cashOpname)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CashOpname $cashOpname)
    {
        //
    }
}
