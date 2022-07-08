<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\CashierOut;
use Gmedia\IspSystem\Models\Journal;

class PraGlCashierOut
{
    public static function create(CashierOut $cashier_out)
    {
        $log = applog('erp, pra_gl_cashier_out__fac, create');
        $log->save('debug');

        $journal = Journal::create([
            'date' => $cashier_out->date,
            'auto_created' => true,
            'cashier_out_id' => $cashier_out->id,

            'branch_id' => $cashier_out->branch_id,
            'chart_of_account_title_id' => $cashier_out->chart_of_account_title_id,

            'code_id' => null,
            'menu_id' => $cashier_out->category->accounting_menu_id,
            'reference' => null,
            'description' => $cashier_out->name,
            'project_id' => null,
            'accounting_division_category_id' => $cashier_out->accounting_division_category_id,

            'submit' => false,
            'submit_at' => null,
            'submit_by' => null,

            'posted' => false,
            'posted_at' => null,
            'posted_by' => null,
        ]);

        $journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $cashier_out->cash_bank->chart_of_account_id,
            'chart_of_account_card_id' => $cashier_out->cash_bank->chart_of_account_card_id,

            'debit' => 0,
            'credit' => $cashier_out->total,
        ]);
    }

    public static function update(CashierOut $cashier_out)
    {        
        $log = applog('erp, pra_gl_cashier_out__fac, update');
        $log->save('debug');

        $cashier_out->journal->update([
            'date' => $cashier_out->date,
            'auto_created' => true,
            'cashier_out_id' => $cashier_out->id,

            'branch_id' => $cashier_out->branch_id,
            'chart_of_account_title_id' => $cashier_out->chart_of_account_title_id,

            'code_id' => null,
            'menu_id' => $cashier_out->category->accounting_menu_id,
            'reference' => null,
            'description' => $cashier_out->name,
            'project_id' => null,
            'accounting_division_category_id' => $cashier_out->accounting_division_category_id,

            'submit' => false,
            'submit_at' => null,
            'submit_by' => null,

            'posted' => false,
            'posted_at' => null,
            'posted_by' => null,
        ]);

        $cashier_out->journal->items()->where('locked_by_journal', true)->delete();

        $cashier_out->journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $cashier_out->cash_bank->chart_of_account_id,
            'chart_of_account_card_id' => $cashier_out->cash_bank->chart_of_account_card_id,

            'debit' => 0,
            'credit' => $cashier_out->total,
        ]);
    }
    
    public static function updateOrCreate(CashierOut $cashier_out)
    {
        $log = applog('erp, pra_gl_cashier_out__fac, update_or_create');
        $log->save('debug');

        if ($cashier_out->journal) {
            static::update($cashier_out);
        } else {
            static::create($cashier_out);
        }
    }

    public static function delete(CashierOut $cashier_out)
    {
        $log = applog('erp, pra_gl_cashier_out__fac, delete');
        $log->save('debug');

        if (!$cashier_out->journal) return;

        $cashier_out->journal->items()->delete();
        
        $cashier_out->journal->journal_ar_invoices()->delete();
        $cashier_out->journal->journal_ap_invoices()->delete();
        $cashier_out->journal->journal_cashier_outs()->delete();
        $cashier_out->journal->journal_cashier_outs()->delete();

        $cashier_out->journal->delete();
    }
}
