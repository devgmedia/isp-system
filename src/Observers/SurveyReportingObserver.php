<?php

namespace Gmedia\IspSystem\Observers;
  
use Gmedia\IspSystem\Models\SurveyReporting as SurveyReportingModel;
use Ramsey\Uuid\Uuid;

class SurveyReportingObserver
{
    public function creating(SurveyReportingModel $SurveyReporting)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (SurveyReportingModel::where('uuid', $uuid)->exists()); 
        if (!$SurveyReporting->uuid) $SurveyReporting->uuid = $uuid;

        $SurveyTasking = DB::table('_survey_tasking')->find($SurveyReporting->survey_tasking_id);

        $get__survey_reporting = DB::table('survey_reporting')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

        $code_date = Carbon::now()->format('my');

        $branch = sprintf("%02d", $SurveyTasking->branch_id);
        $count = sprintf("%04s", $get__survey_reporting + 1);
 
        $SurveyReporting->number = 'PRP/' . $branch . '/' . $code_date . '/' . $count; 
    } 
}
