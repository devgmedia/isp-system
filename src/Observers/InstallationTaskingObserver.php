<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\InstallationTasking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class InstallationTaskingObserver
{
    public function creating(InstallationTasking $InstallationTasking)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (InstallationTasking::where('uuid', $uuid)->exists());

        if (!$InstallationTasking->uuid) $InstallationTasking->uuid = $uuid;

        $InstallationRequest = DB::table('installation_request')->find($InstallationTasking->installation_request_id);

        $get_installation_tasking = DB::table('installation_tasking')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

        $code_date = Carbon::now()->format('my');

        $branch = sprintf("%02d", $InstallationRequest->branch_id);
        $count = sprintf("%04s", $get_installation_tasking + 1);

        $InstallationTasking->number = 'ITA/' . $branch . '/' . $code_date . '/' . $count;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\InstallationTasking  $InstallationTasking
     * @return void
     */
    public function created(InstallationTasking $InstallationTasking)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\InstallationTasking  $InstallationTasking
     * @return void
     */
    public function updated(InstallationTasking $InstallationTasking)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\InstallationTasking  $InstallationTasking
     * @return void
     */
    public function deleted(InstallationTasking $InstallationTasking)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\InstallationTasking  $InstallationTasking
     * @return void
     */
    public function restored(InstallationTasking $InstallationTasking)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\InstallationTasking  $InstallationTasking
     * @return void
     */
    public function forceDeleted(InstallationTasking $InstallationTasking)
    {
        //
    }
}
