<?php

namespace Gmedia\IspSystem\Observers;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\PreSurveyTasking as PreSurveyTaskingModel;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PreSurveyTaskingObserver
{
    public function creating(PreSurveyTaskingModel $PreSurveyTasking)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (PreSurveyTaskingModel::where('uuid', $uuid)->exists());
        if (! $PreSurveyTasking->uuid) {
            $PreSurveyTasking->uuid = $uuid;
        }

        $PreSurveyRequest = DB::table('pre_survey_request')->find($PreSurveyTasking->pre_survey_request_id);

        $get_pre_survey_tasking = DB::table('pre_survey_tasking')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

        $code_date = Carbon::now()->format('my');

        $branch = sprintf('%02d', $PreSurveyRequest->branch_id);
        $count = sprintf('%04s', $get_pre_survey_tasking + 1);

        $PreSurveyTasking->number = 'PTA/'.$branch.'/'.$code_date.'/'.$count;
    }
}
