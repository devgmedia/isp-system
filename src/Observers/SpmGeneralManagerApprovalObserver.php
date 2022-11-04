<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SpmGeneralManagerApproval;
use Ramsey\Uuid\Uuid;

class SpmGeneralManagerApprovalObserver
{
    public function creating(SpmGeneralManagerApproval $spmGeneralManagerApproval)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SpmGeneralManagerApproval::where('uuid', $uuid)->exists());

        if (! $spmGeneralManagerApproval->uuid) {
            $spmGeneralManagerApproval->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\SpmGeneralManagerApproval  $spmGeneralManagerApproval
     * @return void
     */
    public function created(SpmGeneralManagerApproval $spmGeneralManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\SpmGeneralManagerApproval  $spmGeneralManagerApproval
     * @return void
     */
    public function updated(SpmGeneralManagerApproval $spmGeneralManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\SpmGeneralManagerApproval  $spmGeneralManagerApproval
     * @return void
     */
    public function deleted(SpmGeneralManagerApproval $spmGeneralManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\SpmGeneralManagerApproval  $spmGeneralManagerApproval
     * @return void
     */
    public function restored(SpmGeneralManagerApproval $spmGeneralManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\SpmGeneralManagerApproval  $spmGeneralManagerApproval
     * @return void
     */
    public function forceDeleted(SpmGeneralManagerApproval $spmGeneralManagerApproval)
    {
        //
    }
}
