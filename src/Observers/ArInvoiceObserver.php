<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ArInvoice;
use Ramsey\Uuid\Uuid;

class ArInvoiceObserver
{
    public function creating(ArInvoice $arInvoice)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ArInvoice::where('uuid', $uuid)->exists());
        if (! $arInvoice->uuid) {
            $arInvoice->uuid = $uuid;
        }
    }

    /**
     * Handle the ar invoice "created" event.
     *
     * @return void
     */
    public function created(ArInvoice $arInvoice)
    {
        //
    }

    /**
     * Handle the ar invoice "updated" event.
     *
     * @return void
     */
    public function updated(ArInvoice $arInvoice)
    {
        //
    }

    /**
     * Handle the ar invoice "deleted" event.
     *
     * @return void
     */
    public function deleted(ArInvoice $arInvoice)
    {
        //
    }

    /**
     * Handle the ar invoice "restored" event.
     *
     * @return void
     */
    public function restored(ArInvoice $arInvoice)
    {
        //
    }

    /**
     * Handle the ar invoice "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(ArInvoice $arInvoice)
    {
        //
    }
}
