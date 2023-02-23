<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\ProductBrand;
use Ramsey\Uuid\Uuid;

class ProductBrandObserver
{
    public function creating(ProductBrand $productBrand)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (ProductBrand::where('uuid', $uuid)->exists());
        if (! $productBrand->uuid) {
            $productBrand->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(ProductBrand $productBrand)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(ProductBrand $productBrand)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(ProductBrand $productBrand)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(ProductBrand $productBrand)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(ProductBrand $productBrand)
    {
        //
    }
}
