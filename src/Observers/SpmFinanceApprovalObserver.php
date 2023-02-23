<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SpmFinanceApproval;
use Ramsey\Uuid\Uuid;

class SpmFinanceApprovalObserver
{
    public function creating(SpmFinanceApproval $spmFinanceApproval)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SpmFinanceApproval::where('uuid', $uuid)->exists());

        if (! $spmFinanceApproval->uuid) {
            $spmFinanceApproval->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(SpmFinanceApproval $spmFinanceApproval)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(SpmFinanceApproval $spmFinanceApproval)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(SpmFinanceApproval $spmFinanceApproval)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(SpmFinanceApproval $spmFinanceApproval)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SpmFinanceApproval $spmFinanceApproval)
    {
        //
    }
}
