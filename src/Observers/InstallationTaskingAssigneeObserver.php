<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\InstallationTaskingAssignee;
use Ramsey\Uuid\Uuid;

class InstallationTaskingAssigneeObserver
{
    public function creating(InstallationTaskingAssignee $installationTaskingAssignee)
    {
        // do {
        //     $uuid = Uuid::uuid4();
        // } while (InstallationTaskingAssignee::where('uuid', $uuid)->exists());

        // if (!$installationTaskingAssignee->uuid) $installationTaskingAssignee->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(InstallationTaskingAssignee $installationTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(InstallationTaskingAssignee $installationTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(InstallationTaskingAssignee $installationTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(InstallationTaskingAssignee $installationTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(InstallationTaskingAssignee $installationTaskingAssignee)
    {
        //
    }
}
