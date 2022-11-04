<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CashierOutCategory;
use Gmedia\IspSystem\Models\ChartOfAccountTitle;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CashierOutCategoryObserver
{
    public function creating(CashierOutCategory $cashierOutCategory)
    {
        // uuid
        do {
            $uuid = Uuid::uuid4();
        } while (CashierOutCategory::where('uuid', $uuid)->exists());
        if (!$cashierOutCategory->uuid) $cashierOutCategory->uuid = $uuid;

        // code
        if (!$cashierOutCategory->code) {
            $code = null;

            $last_cashier_out_category = DB::table('cashier_out_category')
                ->select(
                    'cashier_out_category.id',
                    'cashier_out_category.code',
                )
                ->where('cashier_out_category.chart_of_account_title_id', $cashierOutCategory->chart_of_account_title_id)
                ->first();

            $last_code = $last_cashier_out_category ? $last_cashier_out_category->code : null;

            if ($last_code) {
                $explode_last_code = explode('/', $last_code);
                $code = $explode_last_code[0].'/'.$explode_last_code[1].'/'.sprintf('%03d', intval($explode_last_code[2]) + 1);
            }

            if (!$code) {
                $chart_of_account_title = ChartOfAccountTitle::find($cashierOutCategory->chart_of_account_title_id);
                $code = 'COC/'.$chart_of_account_title->branch->code.'/'.'001';
            }

            while (DB::table('cashier_out_category')->where('code', $code)->exists()) {
                $explode_code = explode('/', $code);
                $code = $explode_code[0].'/'.$explode_code[1].'/'.sprintf('%03d', intval($explode_code[2]) + 1);
            }

            $cashierOutCategory->code = $code;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierOutCategory  $cashierOutCategory
     * @return void
     */
    public function created(CashierOutCategory $cashierOutCategory)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierOutCategory  $cashierOutCategory
     * @return void
     */
    public function updated(CashierOutCategory $cashierOutCategory)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierOutCategory  $cashierOutCategory
     * @return void
     */
    public function deleted(CashierOutCategory $cashierOutCategory)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierOutCategory  $cashierOutCategory
     * @return void
     */
    public function restored(CashierOutCategory $cashierOutCategory)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashierOutCategory  $cashierOutCategory
     * @return void
     */
    public function forceDeleted(CashierOutCategory $cashierOutCategory)
    {
        //
    }
}
