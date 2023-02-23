<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\HoldAmount;
use Ramsey\Uuid\Uuid;

class HoldAmountObserver
{
    public function creating(HoldAmount $holdAmount)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (HoldAmount::where('uuid', $uuid)->exists());
        if (! $holdAmount->uuid) {
            $holdAmount->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(HoldAmount $holdAmount)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(HoldAmount $holdAmount)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(HoldAmount $holdAmount)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(HoldAmount $holdAmount)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(HoldAmount $holdAmount)
    {
        //
    }
}
