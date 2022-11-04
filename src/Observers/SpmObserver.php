<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Facades\Spm as SpmFac;
use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\Spm;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class SpmObserver
{
    public function creating(Spm $spm)
    {
        // uuid
        if (!$spm->uuid) {
            $uuid = null;
            
            do {
                $uuid = Uuid::uuid4();
            } while (Spm::where('uuid', $uuid)->exists());
    
            $spm->uuid = $uuid;
        }

        // number
        $branch = Branch::find($spm->branch_id);
        $last_spm = Spm::select(
            'spm.id',
            'spm.number',
        )
            ->where('spm.branch_id', $branch->id)
            ->whereMonth('spm.created_at', Carbon::now()->month)
            ->whereYear('spm.created_at', Carbon::now()->year)
            ->orderBy('spm.created_at', 'desc')
            ->first();

        $last_number = $last_spm ? $last_spm->number : null;
        $number = null;

        if ($last_number) {
            $explode_last_number = explode('/', $last_number);
            $number = $explode_last_number[0].'/'.$explode_last_number[1].'/'.$explode_last_number[2].'/'.sprintf('%04d', intval($explode_last_number[3]) + 1);
        }

        if (!$number) {
            $number = 'SPM/'.$branch->code.'/'.Carbon::now()->format('my').'/'.'0001';
        }

        while (Spm::where('number', $number)->exists()) {
            $explode_number = explode('/', $number);
            $number = $explode_number[0].'/'.$explode_number[1].'/'.$explode_number[2].'/'.sprintf('%04d', intval($explode_number[3]) + 1);
        }

        $spm->number = $number;

        // approval_id
        $spm->approval_id = SpmFac::generateApprovalId();
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\Spm  $spm
     * @return void
     */
    public function created(Spm $spm)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\Spm  $spm
     * @return void
     */
    public function updated(Spm $spm)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Spm  $spm
     * @return void
     */
    public function deleted(Spm $spm)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\Spm  $spm
     * @return void
     */
    public function restored(Spm $spm)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\Spm  $spm
     * @return void
     */
    public function forceDeleted(Spm $spm)
    {
        //
    }
}
