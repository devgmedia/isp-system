<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SurveyTasking;
use Ramsey\Uuid\Uuid;

class SurveyTaskingObserver
{
    public function creating(SurveyTasking $surveyTasking)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SurveyTasking::where('uuid', $uuid)->exists());

        if (!$surveyTasking->uuid) $surveyTasking->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTasking  $surveyTasking
     * @return void
     */
    public function created(SurveyTasking $surveyTasking)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTasking  $surveyTasking
     * @return void
     */
    public function updated(SurveyTasking $surveyTasking)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTasking  $surveyTasking
     * @return void
     */
    public function deleted(SurveyTasking $surveyTasking)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTasking  $surveyTasking
     * @return void
     */
    public function restored(SurveyTasking $surveyTasking)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTasking  $surveyTasking
     * @return void
     */
    public function forceDeleted(SurveyTasking $surveyTasking)
    {
        //
    }
}
