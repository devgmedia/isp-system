<?php

namespace Gmedia\IspSystem\Observers;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\InstallationReporting as InstallationReportingModel;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class InstallationReportingObserver
{
    public function creating(InstallationReportingModel $InstallationReporting)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (InstallationReportingModel::where('uuid', $uuid)->exists());
        if (! $InstallationReporting->uuid) {
            $InstallationReporting->uuid = $uuid;
        }

        $installationReporting = DB::table('installation_tasking')->find($InstallationReporting->pre_survey_tasking_id);

        $get_installation_reporting = DB::table('installation_reporting')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

        $code_date = Carbon::now()->format('my');

        $branch = sprintf('%02d', $installationReporting->branch_id);
        $count = sprintf('%04s', $get_installation_reporting + 1);

        $InstallationReporting->number = 'IRP/'.$branch.'/'.$code_date.'/'.$count;
    }
}
