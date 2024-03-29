<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\Product;
use Ramsey\Uuid\Uuid;

class ProductObserver
{
    public function creating(Product $product)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (Product::where('uuid', $uuid)->exists());
        if (! $product->uuid) {
            $product->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
