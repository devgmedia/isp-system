<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SpmBranchManagerApproval;
use Ramsey\Uuid\Uuid;

class SpmBranchManagerApprovalObserver
{
    public function creating(SpmBranchManagerApproval $spmBranchManagerApproval)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SpmBranchManagerApproval::where('uuid', $uuid)->exists());

        if (! $spmBranchManagerApproval->uuid) {
            $spmBranchManagerApproval->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(SpmBranchManagerApproval $spmBranchManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(SpmBranchManagerApproval $spmBranchManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(SpmBranchManagerApproval $spmBranchManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(SpmBranchManagerApproval $spmBranchManagerApproval)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SpmBranchManagerApproval $spmBranchManagerApproval)
    {
        //
    }
}
