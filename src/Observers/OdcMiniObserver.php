<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\OdcMini;
use Ramsey\Uuid\Uuid;

class OdcMiniObserver
{
    public function creating(OdcMini $odc_mini)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (OdcMini::where('uuid', $uuid)->exists());
        if (!$odc_mini->uuid) $odc_mini->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\OdcMini  $odc_mini
     * @return void
     */
    public function created(OdcMini $odc_mini)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\OdcMini  $odc_mini
     * @return void
     */
    public function updated(OdcMini $odc_mini)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\OdcMini  $odc_mini
     * @return void
     */
    public function deleted(OdcMini $odc_mini)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\OdcMini  $odc_mini
     * @return void
     */
    public function restored(OdcMini $odc_mini)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\OdcMini  $odc_mini
     * @return void
     */
    public function forceDeleted(OdcMini $odc_mini)
    {
        //
    }
}
