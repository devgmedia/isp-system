<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Branch;
use Ramsey\Uuid\Uuid;

class BranchObserver
{
    public function creating(Branch $branch)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Branch::where('uuid', $uuid)->exists());
        if (! $branch->uuid) {
            $branch->uuid = $uuid;
        }
    }

    /**
     * Handle the branch "created" event.
     *
     * @return void
     */
    public function created(Branch $branch)
    {
        //
    }

    /**
     * Handle the branch "updated" event.
     *
     * @return void
     */
    public function updated(Branch $branch)
    {
        //
    }

    /**
     * Handle the branch "deleted" event.
     *
     * @return void
     */
    public function deleted(Branch $branch)
    {
        //
    }

    /**
     * Handle the branch "restored" event.
     *
     * @return void
     */
    public function restored(Branch $branch)
    {
        //
    }

    /**
     * Handle the branch "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Branch $branch)
    {
        //
    }
}
