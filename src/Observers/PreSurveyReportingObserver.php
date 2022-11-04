<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\PreSurveyReporting as PreSurveyReportingModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PreSurveyReportingObserver
{
    public function creating(PreSurveyReportingModel $PreSurveyReporting)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (PreSurveyReportingModel::where('uuid', $uuid)->exists());
        if (!$PreSurveyReporting->uuid) $PreSurveyReporting->uuid = $uuid;

        $PreSurveyTasking = DB::table('pre_survey_tasking')->find($PreSurveyReporting->pre_survey_tasking_id);

        $get_pre_survey_reporting = DB::table('pre_survey_reporting')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

        $code_date = Carbon::now()->format('my');

        $branch = sprintf("%02d", $PreSurveyTasking->branch_id);
        $count = sprintf("%04s", $get_pre_survey_reporting + 1);

        $PreSurveyReporting->number = 'PRP/' . $branch . '/' . $code_date . '/' . $count;
    }
}
