<?php

namespace Gmedia\IspSystem\Observers;

use Gmedia\IspSystem\Models\CashBank;
use Gmedia\IspSystem\Models\ChartOfAccountTitle;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class CashBankObserver
{
    public function creating(CashBank $cashBank)
    {
        // uuid
        do {
            $uuid = Uuid::uuid4();
        } while (CashBank::where('uuid', $uuid)->exists());
        if (! $cashBank->uuid) {
            $cashBank->uuid = $uuid;
        }

        // code
        if (! $cashBank->code) {
            $code = null;

            $last_cash_bank = DB::table('cash_bank')
                ->select(
                    'cash_bank.id',
                    'cash_bank.code',
                )
                ->where('cash_bank.chart_of_account_title_id', $cashBank->chart_of_account_title_id)
                ->first();

            $last_code = $last_cash_bank ? $last_cash_bank->code : null;

            if ($last_code) {
                $explode_last_code = explode('/', $last_code);
                $code = $explode_last_code[0].'/'.$explode_last_code[1].'/'.sprintf('%03d', intval($explode_last_code[2]) + 1);
            }

            if (! $code) {
                $chart_of_account_title = ChartOfAccountTitle::find($cashBank->chart_of_account_title_id);
                $code = 'CB/'.$chart_of_account_title->branch->code.'/'.'001';
            }

            while (DB::table('cash_bank')->where('code', $code)->exists()) {
                $explode_code = explode('/', $code);
                $code = $explode_code[0].'/'.$explode_code[1].'/'.sprintf('%03d', intval($explode_code[2]) + 1);
            }

            $cashBank->code = $code;
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashBank  $cashBank
     * @return void
     */
    public function created(CashBank $cashBank)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashBank  $cashBank
     * @return void
     */
    public function updated(CashBank $cashBank)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashBank  $cashBank
     * @return void
     */
    public function deleted(CashBank $cashBank)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashBank  $cashBank
     * @return void
     */
    public function restored(CashBank $cashBank)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @param  \Gmedia\IspSystem\Models\CashBank  $cashBank
     * @return void
     */
    public function forceDeleted(CashBank $cashBank)
    {
        //
    }
}
