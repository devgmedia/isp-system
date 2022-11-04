<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ApInvoice;
use Gmedia\IspSystem\Models\Branch;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ApInvoiceObserver
{
    public function creating(ApInvoice $apInvoice)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ApInvoice::where('uuid', $uuid)->exists());
        if (!$apInvoice->uuid) $apInvoice->uuid = $uuid;

        // number
        $branch = Branch::find($apInvoice->branch_id);
        $last_ap_invoice = ApInvoice::select(
            'ap_invoice.id',
            'ap_invoice.number',
        )
            ->where('ap_invoice.branch_id', $branch->id)
            ->whereMonth('ap_invoice.created_at', Carbon::now()->month)
            ->whereYear('ap_invoice.created_at', Carbon::now()->year)
            ->orderBy('ap_invoice.created_at', 'desc')
            ->first();

        $last_number = $last_ap_invoice ? $last_ap_invoice->number : null;
        $number = null;

        if ($last_number) {
            $explode_last_number = explode('/', $last_number);
            $number = $explode_last_number[0].'/'.$explode_last_number[1].'/'.$explode_last_number[2].'/'.sprintf('%04d', intval($explode_last_number[3]) + 1);
        }

        if (!$number) {
            $number = 'AP/'.$branch->code.'/'.Carbon::now()->format('my').'/'.'0001';
        }

        while (ApInvoice::where('number', $number)->exists()) {
            $explode_number = explode('/', $number);
            $number = $explode_number[0].'/'.$explode_number[1].'/'.$explode_number[2].'/'.sprintf('%04d', intval($explode_number[3]) + 1);
        }

        $apInvoice->number = $number;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoice  $apInvoice
     * @return void
     */
    public function created(ApInvoice $apInvoice)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoice  $apInvoice
     * @return void
     */
    public function updated(ApInvoice $apInvoice)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoice  $apInvoice
     * @return void
     */
    public function deleted(ApInvoice $apInvoice)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoice  $apInvoice
     * @return void
     */
    public function restored(ApInvoice $apInvoice)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoice  $apInvoice
     * @return void
     */
    public function forceDeleted(ApInvoice $apInvoice)
    {
        //
    }
}
