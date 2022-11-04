<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\TaxOut;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class TaxOutObserver
{
    public function creating(TaxOut $taxOut)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (TaxOut::where('uuid', $uuid)->exists());
        if (!$taxOut->uuid) $taxOut->uuid = $uuid;

        // number
        $branch = Branch::find($taxOut->branch_id);
        $last_tax_out = TaxOut::select(
            'tax_out.id',
            'tax_out.number',
        )
            ->where('tax_out.branch_id', $branch->id)
            ->whereMonth('tax_out.created_at', Carbon::now()->month)
            ->whereYear('tax_out.created_at', Carbon::now()->year)
            ->orderBy('tax_out.created_at', 'desc')
            ->first();

        $last_number = $last_tax_out ? $last_tax_out->number : null;
        $number = null;

        if ($last_number) {
            $explode_last_number = explode('/', $last_number);
            $number = $explode_last_number[0].'/'.$explode_last_number[1].'/'.$explode_last_number[2].'/'.sprintf('%04d', intval($explode_last_number[3]) + 1);
        }

        if (!$number) {
            $number = 'TO/'.$branch->code.'/'.Carbon::now()->format('my').'/'.'0001';
        }

        while (TaxOut::where('number', $number)->exists()) {
            $explode_number = explode('/', $number);
            $number = $explode_number[0].'/'.$explode_number[1].'/'.$explode_number[2].'/'.sprintf('%04d', intval($explode_number[3]) + 1);
        }

        $taxOut->number = $number;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxOut  $taxOut
     * @return void
     */
    public function created(TaxOut $taxOut)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxOut  $taxOut
     * @return void
     */
    public function updated(TaxOut $taxOut)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxOut  $taxOut
     * @return void
     */
    public function deleted(TaxOut $taxOut)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxOut  $taxOut
     * @return void
     */
    public function restored(TaxOut $taxOut)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxOut  $taxOut
     * @return void
     */
    public function forceDeleted(TaxOut $taxOut)
    {
        //
    }
}
