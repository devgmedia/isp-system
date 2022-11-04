<?php

namespace Gmedia\IspSystem\Observers;

use Ramsey\Uuid\Uuid;

// models
use Gmedia\IspSystem\Models\TrialRequest;

class TrialRequestObserve
{
    public function creating(TrialRequest $trial_request)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (TrialRequest::where('uuid', $uuid)->exists());

        $trial_request->uuid = $uuid;
    }

    /**
     * Handle the TrialRequest "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\TrialRequest  $trial_request
     * @return void
     */
    public function created(TrialRequest $trial_request)
    {
        //
    }

    /**
     * Handle the TrialRequest "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\TrialRequest  $trial_request
     * @return void
     */
    public function updated(TrialRequest $trial_request)
    {
        //
    }

    /**
     * Handle the TrialRequest "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\TrialRequest  $trial_request
     * @return void
     */
    public function deleted(TrialRequest $trial_request)
    {
        //
    }

    /**
     * Handle the TrialRequest "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\TrialRequest  $trial_request
     * @return void
     */
    public function restored(TrialRequest $trial_request)
    {
        //
    }

    /**
     * Handle the TrialRequest "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\TrialRequest  $trial_request
     * @return void
     */
    public function forceDeleted(TrialRequest $trial_request)
    {
        //
    }
}
