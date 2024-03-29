<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ChartOfAccountTitle;
use Ramsey\Uuid\Uuid;

class ChartOfAccountTitleObserver
{
    public function creating(ChartOfAccountTitle $chartOfAccountTitle)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ChartOfAccountTitle::where('uuid', $uuid)->exists());
        if (! $chartOfAccountTitle->uuid) {
            $chartOfAccountTitle->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(ChartOfAccountTitle $chartOfAccountTitle)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(ChartOfAccountTitle $chartOfAccountTitle)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(ChartOfAccountTitle $chartOfAccountTitle)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(ChartOfAccountTitle $chartOfAccountTitle)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(ChartOfAccountTitle $chartOfAccountTitle)
    {
        //
    }
}
