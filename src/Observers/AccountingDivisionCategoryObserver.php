<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\AccountingDivisionCategory;
use Ramsey\Uuid\Uuid;

class AccountingDivisionCategoryObserver
{
    public function creating(AccountingDivisionCategory $accountingDivisionCategory)
    {
        do {
            $uuid = Uuid::uuid4();
        } while (AccountingDivisionCategory::where('uuid', $uuid)->exists());
        if (!$accountingDivisionCategory->uuid) $accountingDivisionCategory->uuid = $uuid;
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\AccountingDivisionCategory  $accountingDivisionCategory
     * @return void
     */
    public function created(AccountingDivisionCategory $accountingDivisionCategory)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\AccountingDivisionCategory  $accountingDivisionCategory
     * @return void
     */
    public function updated(AccountingDivisionCategory $accountingDivisionCategory)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\AccountingDivisionCategory  $accountingDivisionCategory
     * @return void
     */
    public function deleted(AccountingDivisionCategory $accountingDivisionCategory)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\AccountingDivisionCategory  $accountingDivisionCategory
     * @return void
     */
    public function restored(AccountingDivisionCategory $accountingDivisionCategory)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\AccountingDivisionCategory  $accountingDivisionCategory
     * @return void
     */
    public function forceDeleted(AccountingDivisionCategory $accountingDivisionCategory)
    {
        //
    }
}
