<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CustomerVisit;
use Ramsey\Uuid\Uuid;

class CustomerVisitObserver
{
    public function creating(CustomerVisit $customerVisit)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (CustomerVisit::where('uuid', $uuid)->exists());
        if (!$customerVisit->uuid) $customerVisit->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerVisit  $customerVisit
     * @return void
     */
    public function created(CustomerVisit $customerVisit)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerVisit  $customerVisit
     * @return void
     */
    public function updated(CustomerVisit $customerVisit)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerVisit  $customerVisit
     * @return void
     */
    public function deleted(CustomerVisit $customerVisit)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerVisit  $customerVisit
     * @return void
     */
    public function restored(CustomerVisit $customerVisit)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CustomerVisit  $customerVisit
     * @return void
     */
    public function forceDeleted(CustomerVisit $customerVisit)
    {
        //
    }
}
