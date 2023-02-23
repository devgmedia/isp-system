<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SurveyRequest;
// models
use Ramsey\Uuid\Uuid;

class SurveyRequestObserver
{
    public function creating(SurveyRequest $survey_request)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SurveyRequest::where('uuid', $uuid)->exists());

        $survey_request->uuid = $uuid;
    }

    /**
     * Handle the SurveyRequest "created" event.
     *
     * @return void
     */
    public function created(SurveyRequest $survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "updated" event.
     *
     * @return void
     */
    public function updated(SurveyRequest $survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "deleted" event.
     *
     * @return void
     */
    public function deleted(SurveyRequest $survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "restored" event.
     *
     * @return void
     */
    public function restored(SurveyRequest $survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(SurveyRequest $survey_request)
    {
        //
    }
}
