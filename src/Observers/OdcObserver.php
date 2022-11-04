<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Odc;
use Ramsey\Uuid\Uuid;

class OdcObserver
{
    public function creating(Odc $odc)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Odc::where('uuid', $uuid)->exists());
        if (!$odc->uuid) $odc->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Odc  $odc
     * @return void
     */
    public function created(Odc $odc)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Odc  $odc
     * @return void
     */
    public function updated(Odc $odc)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Odc  $odc
     * @return void
     */
    public function deleted(Odc $odc)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Odc  $odc
     * @return void
     */
    public function restored(Odc $odc)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Odc  $odc
     * @return void
     */
    public function forceDeleted(Odc $odc)
    {
        //
    }
}
