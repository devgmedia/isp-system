<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ApInvoiceSource;
use Ramsey\Uuid\Uuid;

class ApInvoiceSourceObserver
{
    public function creating(ApInvoiceSource $apInvoiceSource)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ApInvoiceSource::where('uuid', $uuid)->exists());
        if (!$apInvoiceSource->uuid) $apInvoiceSource->uuid = $uuid;
    }

    /**
     * Handle the ar invoice "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoiceSource  $apInvoiceSource
     * @return void
     */
    public function created(ApInvoiceSource $apInvoiceSource)
    {
        //
    }

    /**
     * Handle the ar invoice "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoiceSource  $apInvoiceSource
     * @return void
     */
    public function updated(ApInvoiceSource $apInvoiceSource)
    {
        //
    }

    /**
     * Handle the ar invoice "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoiceSource  $apInvoiceSource
     * @return void
     */
    public function deleted(ApInvoiceSource $apInvoiceSource)
    {
        //
    }

    /**
     * Handle the ar invoice "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoiceSource  $apInvoiceSource
     * @return void
     */
    public function restored(ApInvoiceSource $apInvoiceSource)
    {
        //
    }

    /**
     * Handle the ar invoice "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ApInvoiceSource  $apInvoiceSource
     * @return void
     */
    public function forceDeleted(ApInvoiceSource $apInvoiceSource)
    {
        //
    }
}
