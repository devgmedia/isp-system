<?php

namespace Gmedia\IspSystem\Observers;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\TaxIn;
use Ramsey\Uuid\Uuid;

class TaxInObserver
{
    public function creating(TaxIn $taxIn)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (TaxIn::where('uuid', $uuid)->exists());
        if (! $taxIn->uuid) {
            $taxIn->uuid = $uuid;
        }

        // number
        $branch = Branch::find($taxIn->branch_id);
        $last_tax_in = TaxIn::select(
            'tax_in.id',
            'tax_in.number',
        )
            ->where('tax_in.branch_id', $branch->id)
            ->whereMonth('tax_in.created_at', Carbon::now()->month)
            ->whereYear('tax_in.created_at', Carbon::now()->year)
            ->orderBy('tax_in.created_at', 'desc')
            ->first();

        $last_number = $last_tax_in ? $last_tax_in->number : null;
        $number = null;

        if ($last_number) {
            $explode_last_number = explode('/', $last_number);
            $number = $explode_last_number[0].'/'.$explode_last_number[1].'/'.$explode_last_number[2].'/'.sprintf('%04d', intval($explode_last_number[3]) + 1);
        }

        if (! $number) {
            $number = 'TI/'.$branch->code.'/'.Carbon::now()->format('my').'/'.'0001';
        }

        while (TaxIn::where('number', $number)->exists()) {
            $explode_number = explode('/', $number);
            $number = $explode_number[0].'/'.$explode_number[1].'/'.$explode_number[2].'/'.sprintf('%04d', intval($explode_number[3]) + 1);
        }

        $taxIn->number = $number;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxIn  $taxIn
     * @return void
     */
    public function created(TaxIn $taxIn)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxIn  $taxIn
     * @return void
     */
    public function updated(TaxIn $taxIn)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxIn  $taxIn
     * @return void
     */
    public function deleted(TaxIn $taxIn)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxIn  $taxIn
     * @return void
     */
    public function restored(TaxIn $taxIn)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\TaxIn  $taxIn
     * @return void
     */
    public function forceDeleted(TaxIn $taxIn)
    {
        //
    }
}
