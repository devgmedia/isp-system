<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ProductAdditional;
use Ramsey\Uuid\Uuid;

class ProductAdditionalObserver
{
    public function creating(ProductAdditional $productAdditional)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ProductAdditional::where('uuid', $uuid)->exists());
        if (! $productAdditional->uuid) {
            $productAdditional->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(ProductAdditional $productAdditional)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(ProductAdditional $productAdditional)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(ProductAdditional $productAdditional)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(ProductAdditional $productAdditional)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(ProductAdditional $productAdditional)
    {
        //
    }
}
