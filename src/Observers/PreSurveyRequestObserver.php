<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Employee;
use Gmedia\IspSystem\Models\PreSurveyRequest;
use Illuminate\Support\Facades\Auth;
// models
use Ramsey\Uuid\Uuid;

class PreSurveyRequestObserver
{
    public function creating(PreSurveyRequest $pre_survey_request)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (PreSurveyRequest::where('uuid', $uuid)->exists());

        $employe = Employee::where('user_id', Auth::id())->first();
        $pre_survey = PreSurveyRequest::where('branch_id', $employe->branch->id)
            ->whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('m'))
            ->count();

        $number = $pre_survey + 1;
        $num_padded = sprintf('%04s', $number);

        $pre_survey_request->number = 'PRE/'.$employe->branch->code.'/'.date('m').date('y').'/'.$num_padded;
        $pre_survey_request->uuid = $uuid;
    }

    /**
     * Handle the PreSurveyRequest "created" event.
     *
     * @return void
     */
    public function created(PreSurveyRequest $pre_survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "updated" event.
     *
     * @return void
     */
    public function updated(PreSurveyRequest $pre_survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "deleted" event.
     *
     * @return void
     */
    public function deleted(PreSurveyRequest $pre_survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "restored" event.
     *
     * @return void
     */
    public function restored(PreSurveyRequest $pre_survey_request)
    {
        //
    }

    /**
     * Handle the Precustomer "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(PreSurveyRequest $pre_survey_request)
    {
        //
    }
}
