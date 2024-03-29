<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CashierOut;
use Ramsey\Uuid\Uuid;

class CashierOutObserver
{
    public function creating(CashierOut $cashierOut)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (CashierOut::where('uuid', $uuid)->exists());
        if (! $cashierOut->uuid) {
            $cashierOut->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(CashierOut $cashierOut)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(CashierOut $cashierOut)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(CashierOut $cashierOut)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(CashierOut $cashierOut)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CashierOut $cashierOut)
    {
        //
    }
}
