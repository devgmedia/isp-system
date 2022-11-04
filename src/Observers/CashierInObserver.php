<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CashierIn;
use Ramsey\Uuid\Uuid;

class CashierInObserver
{
    public function creating(CashierIn $cashierIn)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (CashierIn::where('uuid', $uuid)->exists());
        if (!$cashierIn->uuid) $cashierIn->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierIn  $cashierIn
     * @return void
     */
    public function created(CashierIn $cashierIn)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierIn  $cashierIn
     * @return void
     */
    public function updated(CashierIn $cashierIn)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierIn  $cashierIn
     * @return void
     */
    public function deleted(CashierIn $cashierIn)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierIn  $cashierIn
     * @return void
     */
    public function restored(CashierIn $cashierIn)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierIn  $cashierIn
     * @return void
     */
    public function forceDeleted(CashierIn $cashierIn)
    {
        //
    }
}
