<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\CashierIn;
use Gmedia\IspSystem\Models\Journal;

class PraGlCashierIn
{
    public static function create(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier_in__fac, create');
        $log->save('debug');

        $journal = Journal::create([
            'date' => $cashier_in->date,
            'auto_created' => true,
            'cashier_in_id' => $cashier_in->id,

            'branch_id' => $cashier_in->branch_id,
            'chart_of_account_title_id' => $cashier_in->chart_of_account_title_id,

            'code_id' => null,
            'menu_id' => $cashier_in->category->accounting_menu_id,
            'reference' => null,
            'description' => $cashier_in->name,
            'project_id' => null,
            'accounting_division_category_id' => $cashier_in->category->accounting_division_category_id,

            'submit' => false,
            'submit_at' => null,
            'submit_by' => null,

            'posted' => false,
            'posted_at' => null,
            'posted_by' => null,
        ]);

        $journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $cashier_in->cash_bank->chart_of_account_id,
            'chart_of_account_card_id' => $cashier_in->cash_bank->chart_of_account_card_id,

            'debit' => $cashier_in->total,
            'credit' => 0,
        ]);
    }

    public static function update(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier_in__fac, update');
        $log->save('debug');

        $cashier_in->journal->update([
            'date' => $cashier_in->date,
            'auto_created' => true,
            'cashier_in_id' => $cashier_in->id,

            'branch_id' => $cashier_in->branch_id,
            'chart_of_account_title_id' => $cashier_in->chart_of_account_title_id,

            'code_id' => null,
            'menu_id' => $cashier_in->category->accounting_menu_id,
            'reference' => null,
            'description' => $cashier_in->name,
            'project_id' => null,
            'accounting_division_category_id' => $cashier_in->category->accounting_division_category_id,

            'submit' => false,
            'submit_at' => null,
            'submit_by' => null,

            'posted' => false,
            'posted_at' => null,
            'posted_by' => null,
        ]);

        $cashier_in->journal->items()->where('locked_by_journal', true)->delete();

        $cashier_in->journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $cashier_in->cash_bank->chart_of_account_id,
            'chart_of_account_card_id' => $cashier_in->cash_bank->chart_of_account_card_id,

            'debit' => $cashier_in->total,
            'credit' => 0,
        ]);
    }

    public static function updateOrCreate(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier_in__fac, update_or_create');
        $log->save('debug');

        if ($cashier_in->journal) {
            static::update($cashier_in);
        } else {
            static::create($cashier_in);
        }
    }

    public static function delete(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier_in__fac, delete');
        $log->save('debug');

        if (! $cashier_in->journal) {
            return;
        }

        $cashier_in->journal->items()->delete();

        $cashier_in->journal->journal_ar_invoices()->delete();
        $cashier_in->journal->journal_ap_invoices()->delete();
        $cashier_in->journal->journal_cashier_ins()->delete();
        $cashier_in->journal->journal_cashier_outs()->delete();

        $cashier_in->journal->delete();
    }
}
