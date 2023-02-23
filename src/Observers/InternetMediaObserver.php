<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\InternetMedia;
use Ramsey\Uuid\Uuid;

class InternetMediaObserver
{
    public function creating(InternetMedia $internet_media)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (InternetMedia::where('uuid', $uuid)->exists());
        if (! $internet_media->uuid) {
            $internet_media->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(InternetMedia $internet_media)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(InternetMedia $internet_media)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(InternetMedia $internet_media)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(InternetMedia $internet_media)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(InternetMedia $internet_media)
    {
        //
    }
}
