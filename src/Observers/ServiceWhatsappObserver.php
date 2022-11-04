<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ServiceWhatsapp;
use Ramsey\Uuid\Uuid;

class ServiceWhatsappObserver
{
    public function creating(ServiceWhatsapp $serviceWhatsapp)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ServiceWhatsapp::where('uuid', $uuid)->exists());
        if (!$serviceWhatsapp->uuid) $serviceWhatsapp->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\ServiceWhatsapp  $serviceWhatsapp
     * @return void
     */
    public function created(ServiceWhatsapp $serviceWhatsapp)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\ServiceWhatsapp  $serviceWhatsapp
     * @return void
     */
    public function updated(ServiceWhatsapp $serviceWhatsapp)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ServiceWhatsapp  $serviceWhatsapp
     * @return void
     */
    public function deleted(ServiceWhatsapp $serviceWhatsapp)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\ServiceWhatsapp  $serviceWhatsapp
     * @return void
     */
    public function restored(ServiceWhatsapp $serviceWhatsapp)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\ServiceWhatsapp  $serviceWhatsapp
     * @return void
     */
    public function forceDeleted(ServiceWhatsapp $serviceWhatsapp)
    {
        //
    }
}
