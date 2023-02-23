<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SpmDirectorApproval;
use Ramsey\Uuid\Uuid;

class SpmDirectorApprovalObserver
{
    public function creating(SpmDirectorApproval $spmDirectorApproval)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SpmDirectorApproval::where('uuid', $uuid)->exists());

        if (! $spmDirectorApproval->uuid) {
            $spmDirectorApproval->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(SpmDirectorApproval $spmDirectorApproval)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(SpmDirectorApproval $spmDirectorApproval)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(SpmDirectorApproval $spmDirectorApproval)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(SpmDirectorApproval $spmDirectorApproval)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SpmDirectorApproval $spmDirectorApproval)
    {
        //
    }
}
