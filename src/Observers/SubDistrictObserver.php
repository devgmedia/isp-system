<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SubDistrict;
use Ramsey\Uuid\Uuid;

class SubDistrictObserver
{
    public function creating(SubDistrict $sub_district)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SubDistrict::where('uuid', $uuid)->exists());
        if (! $sub_district->uuid) {
            $sub_district->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(SubDistrict $sub_district)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(SubDistrict $sub_district)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(SubDistrict $sub_district)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(SubDistrict $sub_district)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SubDistrict $sub_district)
    {
        //
    }
}
