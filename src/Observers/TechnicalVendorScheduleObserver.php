<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\TechnicalVendorSchedule;
use Ramsey\Uuid\Uuid;

class TechnicalVendorScheduleObserver
{
    public function creating(TechnicalVendorSchedule $technical_vendor_schedule)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (TechnicalVendorSchedule::where('uuid', $uuid)->exists());
        if (! $technical_vendor_schedule->uuid) {
            $technical_vendor_schedule->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(TechnicalVendorSchedule $technical_vendor_schedule)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(TechnicalVendorSchedule $technical_vendor_schedule)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(TechnicalVendorSchedule $technical_vendor_schedule)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(TechnicalVendorSchedule $technical_vendor_schedule)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(TechnicalVendorSchedule $technical_vendor_schedule)
    {
        //
    }
}
