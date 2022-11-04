<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Village;
use Ramsey\Uuid\Uuid;

class VillageObserver
{
    public function creating(Village $village)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Village::where('uuid', $uuid)->exists());
        if (! $village->uuid) {
            $village->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Village  $village
     * @return void
     */
    public function created(Village $village)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Village  $village
     * @return void
     */
    public function updated(Village $village)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Village  $village
     * @return void
     */
    public function deleted(Village $village)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Village  $village
     * @return void
     */
    public function restored(Village $village)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Village  $village
     * @return void
     */
    public function forceDeleted(Village $village)
    {
        //
    }
}
