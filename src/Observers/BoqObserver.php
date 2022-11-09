<?php

namespace Gmedia\IspSystem\Observers;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\Boq;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class BoqObserver
{
    public function creating(Boq $boq)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Boq::where('uuid', $uuid)->exists());
        if (! $boq->uuid) {
            $survey_reporting = DB::table('survey_reporting')->find($boq->survey_reporting_id);

            $get_boq = DB::table('boq')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

            $code_date = Carbon::now()->format('my');

            $branch = sprintf('%02d', $survey_reporting->branch_id);
            $count = sprintf('%04s', $get_boq + 1);

            $boq->uuid = $uuid;
            $boq->number = 'BOQ/'.$branch.'/'.$code_date.'/'.$count;
            $boq->date = Carbon::now();
            $boq->branch_id = $survey_reporting->branch_id;
            $boq->pre_customer_id = $survey_reporting->pre_customer_id;
        }
    }

    /**
     * Handle the boq "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Boq  $boq
     * @return void
     */
    public function created(Boq $boq)
    {
        //
    }

    /**
     * Handle the boq "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Boq  $boq
     * @return void
     */
    public function updated(Boq $boq)
    {
        //
    }

    /**
     * Handle the boq "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Boq  $boq
     * @return void
     */
    public function deleted(Boq $boq)
    {
        //
    }

    /**
     * Handle the boq "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Boq  $boq
     * @return void
     */
    public function restored(Boq $boq)
    {
        //
    }

    /**
     * Handle the boq "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Boq  $boq
     * @return void
     */
    public function forceDeleted(Boq $boq)
    {
        //
    }
}
