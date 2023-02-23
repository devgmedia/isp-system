<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CustomerCategory;
use Ramsey\Uuid\Uuid;

class CustomerCategoryObserver
{
    public function creating(CustomerCategory $customerCategory)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (CustomerCategory::where('uuid', $uuid)->exists());
        if (! $customerCategory->uuid) {
            $customerCategory->uuid = $uuid;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(CustomerCategory $customerCategory)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(CustomerCategory $customerCategory)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(CustomerCategory $customerCategory)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(CustomerCategory $customerCategory)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(CustomerCategory $customerCategory)
    {
        //
    }
}
