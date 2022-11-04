<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\SurveyTaskingAssignee;
use Ramsey\Uuid\Uuid;

class SurveyTaskingAssigneeObserver
{
    public function creating(SurveyTaskingAssignee $surveyTaskingAssignee)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SurveyTaskingAssignee::where('uuid', $uuid)->exists());

        if (! $surveyTaskingAssignee->uuid) {
            $surveyTaskingAssignee->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTaskingAssignee  $surveyTaskingAssignee
     * @return void
     */
    public function created(SurveyTaskingAssignee $surveyTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTaskingAssignee  $surveyTaskingAssignee
     * @return void
     */
    public function updated(SurveyTaskingAssignee $surveyTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTaskingAssignee  $surveyTaskingAssignee
     * @return void
     */
    public function deleted(SurveyTaskingAssignee $surveyTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTaskingAssignee  $surveyTaskingAssignee
     * @return void
     */
    public function restored(SurveyTaskingAssignee $surveyTaskingAssignee)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\SurveyTaskingAssignee  $surveyTaskingAssignee
     * @return void
     */
    public function forceDeleted(SurveyTaskingAssignee $surveyTaskingAssignee)
    {
        //
    }
}
