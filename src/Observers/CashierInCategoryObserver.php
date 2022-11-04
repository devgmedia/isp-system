<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CashierInCategory;
use Gmedia\IspSystem\Models\ChartOfAccountTitle;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CashierInCategoryObserver
{
    public function creating(CashierInCategory $cashierInCategory)
    {
        // uuid
        do {
            $uuid = Uuid::uuid4();
        } while (CashierInCategory::where('uuid', $uuid)->exists());
        if (!$cashierInCategory->uuid) $cashierInCategory->uuid = $uuid;

        // code
        if (!$cashierInCategory->code) {
            $code = null;

            $last_cashier_in_category = DB::table('cashier_in_category')
                ->select(
                    'cashier_in_category.id',
                    'cashier_in_category.code',
                )
                ->where('cashier_in_category.chart_of_account_title_id', $cashierInCategory->chart_of_account_title_id)
                ->first();

            $last_code = $last_cashier_in_category ? $last_cashier_in_category->code : null;

            if ($last_code) {
                $explode_last_code = explode('/', $last_code);
                $code = $explode_last_code[0].'/'.$explode_last_code[1].'/'.sprintf('%03d', intval($explode_last_code[2]) + 1);
            }

            if (!$code) {
                $chart_of_account_title = ChartOfAccountTitle::find($cashierInCategory->chart_of_account_title_id);
                $code = 'CIC/'.$chart_of_account_title->branch->code.'/'.'001';
            }

            while (DB::table('cashier_in_category')->where('code', $code)->exists()) {
                $explode_code = explode('/', $code);
                $code = $explode_code[0].'/'.$explode_code[1].'/'.sprintf('%03d', intval($explode_code[2]) + 1);
            }

            $cashierInCategory->code = $code;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierInCategory  $cashierInCategory
     * @return void
     */
    public function created(CashierInCategory $cashierInCategory)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierInCategory  $cashierInCategory
     * @return void
     */
    public function updated(CashierInCategory $cashierInCategory)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierInCategory  $cashierInCategory
     * @return void
     */
    public function deleted(CashierInCategory $cashierInCategory)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierInCategory  $cashierInCategory
     * @return void
     */
    public function restored(CashierInCategory $cashierInCategory)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierInCategory  $cashierInCategory
     * @return void
     */
    public function forceDeleted(CashierInCategory $cashierInCategory)
    {
        //
    }
}
