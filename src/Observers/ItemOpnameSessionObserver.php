<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ItemOpnameSession;

class ItemOpnameSessionObserver
{
    /**
     * Handle the item "created" event.
     *
     * @param  \Gmedia\IspSystem\ItemOpnameSession  $item
     * @return void
     */
    public function creating(ItemOpnameSession $item)
    {
        //
    }

    public function created(ItemOpnameSession $item)
    {
        //
    }

    /**
     * Handle the item "updated" event.
     *
     * @param  \Gmedia\IspSystem\ItemOpnameSession  $item
     * @return void
     */
    public function updated(ItemOpnameSession $item)
    {
        //
    }

    /**
     * Handle the item "deleted" event.
     *
     * @param  \Gmedia\IspSystem\ItemOpnameSession  $item
     * @return void
     */
    public function deleted(ItemOpnameSession $item)
    {
        //
    }

    /**
     * Handle the item "restored" event.
     *
     * @param  \Gmedia\IspSystem\ItemOpnameSession  $item
     * @return void
     */
    public function restored(ItemOpnameSession $item)
    {
        //
    }

    /**
     * Handle the item "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\ItemOpnameSession  $item
     * @return void
     */
    public function forceDeleted(ItemOpnameSession $item)
    {
        //
    }
}
