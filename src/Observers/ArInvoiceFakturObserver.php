<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ArInvoiceFaktur;
use Ramsey\Uuid\Uuid;

class ArInvoiceFakturObserver
{
    public function creating(ArInvoiceFaktur $arInvoiceFaktur)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ArInvoiceFaktur::where('uuid', $uuid)->exists());
        if (!$arInvoiceFaktur->uuid) $arInvoiceFaktur->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceFaktur  $arInvoiceFaktur
     * @return void
     */
    public function created(ArInvoiceFaktur $arInvoiceFaktur)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceFaktur  $arInvoiceFaktur
     * @return void
     */
    public function updated(ArInvoiceFaktur $arInvoiceFaktur)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceFaktur  $arInvoiceFaktur
     * @return void
     */
    public function deleted(ArInvoiceFaktur $arInvoiceFaktur)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceFaktur  $arInvoiceFaktur
     * @return void
     */
    public function restored(ArInvoiceFaktur $arInvoiceFaktur)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ArInvoiceFaktur  $arInvoiceFaktur
     * @return void
     */
    public function forceDeleted(ArInvoiceFaktur $arInvoiceFaktur)
    {
        //
    }
}
