<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Rab;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RabObserver
{
    public function creating(Rab $rab)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Rab::where('uuid', $uuid)->exists());
        if (!$rab->uuid) {

            $survey_reporting = DB::table('survey_reporting')->find($rab->survey_reporting_id);

            $get_rab = DB::table('rab')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

            $code_date = Carbon::now()->format('my');

            $branch = sprintf("%02d", $survey_reporting->branch_id);
            $count = sprintf("%04s", $get_rab + 1);

            $rab->uuid = $uuid;
            $rab->number = 'IRP/' . $branch . '/' . $code_date . '/' . $count;
            $rab->date = Carbon::now();
            $rab->branch_id = $survey_reporting->branch_id;
            $rab->pre_customer_id = $survey_reporting->pre_customer_id;
        };
    }

    /**
     * Handle the rab "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Rab  $rab
     * @return void
     */
    public function created(Rab $rab)
    {
        //
    }

    /**
     * Handle the rab "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Rab  $rab
     * @return void
     */
    public function updated(Rab $rab)
    {
        //
    }

    /**
     * Handle the rab "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Rab  $rab
     * @return void
     */
    public function deleted(Rab $rab)
    {
        //
    }

    /**
     * Handle the rab "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Rab  $rab
     * @return void
     */
    public function restored(Rab $rab)
    {
        //
    }

    /**
     * Handle the rab "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Rab  $rab
     * @return void
     */
    public function forceDeleted(Rab $rab)
    {
        //
    }
}
