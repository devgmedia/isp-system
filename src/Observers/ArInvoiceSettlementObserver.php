<?php

namespace Gmedia\IspSystem\Observers;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\ArInvoiceSettlement;
use Gmedia\IspSystem\Models\Branch;
use Ramsey\Uuid\Uuid;

class ArInvoiceSettlementObserver
{
    public function creating(ArInvoiceSettlement $arInvoiceSettlement)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ArInvoiceSettlement::where('uuid', $uuid)->exists());
        if (! $arInvoiceSettlement->uuid) {
            $arInvoiceSettlement->uuid = $uuid;
        }

        // number
        $branch = Branch::find($arInvoiceSettlement->branch_id);
        $last_settlement = ArInvoiceSettlement::select(
            'ar_invoice_settlement.id',
            'ar_invoice_settlement.number',
        )
            ->where('ar_invoice_settlement.branch_id', $branch->id)
            ->whereMonth('ar_invoice_settlement.created_at', Carbon::now()->month)
            ->whereYear('ar_invoice_settlement.created_at', Carbon::now()->year)
            ->orderBy('ar_invoice_settlement.created_at', 'desc')
            ->first();

        $last_number = $last_settlement ? $last_settlement->number : null;
        $number = null;

        if ($last_number) {
            $explode_last_number = explode('/', $last_number);
            $number = $explode_last_number[0].'/'.$explode_last_number[1].'/'.$explode_last_number[2].'/'.sprintf('%04d', intval($explode_last_number[3]) + 1);
        }

        if (! $number) {
            $number = 'CR/'.$branch->code.'/'.Carbon::now()->format('my').'/'.'0001';
        }

        while (ArInvoiceSettlement::where('number', $number)->exists()) {
            $explode_number = explode('/', $number);
            $number = $explode_number[0].'/'.$explode_number[1].'/'.$explode_number[2].'/'.sprintf('%04d', intval($explode_number[3]) + 1);
        }

        $arInvoiceSettlement->number = $number;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceSettlement  $arInvoiceSettlement
     * @return void
     */
    public function created(ArInvoiceSettlement $arInvoiceSettlement)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceSettlement  $arInvoiceSettlement
     * @return void
     */
    public function updated(ArInvoiceSettlement $arInvoiceSettlement)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceSettlement  $arInvoiceSettlement
     * @return void
     */
    public function deleted(ArInvoiceSettlement $arInvoiceSettlement)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceSettlement  $arInvoiceSettlement
     * @return void
     */
    public function restored(ArInvoiceSettlement $arInvoiceSettlement)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceSettlement  $arInvoiceSettlement
     * @return void
     */
    public function forceDeleted(ArInvoiceSettlement $arInvoiceSettlement)
    {
        //
    }
}
