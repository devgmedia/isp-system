<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Vlan;
use Ramsey\Uuid\Uuid;

class VlanObserver
{
    public function creating(Vlan $vlan)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Vlan::where('uuid', $uuid)->exists());
        if (! $vlan->uuid) {
            $vlan->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Vlan $vlan)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Vlan $vlan)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Vlan $vlan)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Vlan $vlan)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Vlan $vlan)
    {
        //
    }
}
