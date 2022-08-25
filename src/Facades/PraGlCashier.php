<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\CashierIn;
use Gmedia\IspSystem\Models\CashierOut;
use Gmedia\IspSystem\Models\Journal;

class PraGlCashier
{
    public static function createFromCashierIn(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier__fac, create_from_cashier_in');
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

        if ($cashier_in->category->chart_of_account_id) {
            $journal->items()->create([
                'locked_by_journal' => true,

                'chart_of_account_id' => $cashier_in->category->chart_of_account_id,
                'chart_of_account_card_id' => $cashier_in->category->chart_of_account_card_id,

                'debit' => $cashier_in->total,
                'credit' => 0,
            ]);
        }
    }

    public static function createFromCashierOut(CashierOut $cashier_out)
    {
        $log = applog('erp, pra_gl_cashier__fac, create_from_cashier_out');
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

        if ($cashier_out->category->chart_of_account_id) {
            $journal->items()->create([
                'locked_by_journal' => true,

                'chart_of_account_id' => $cashier_out->category->chart_of_account_id,
                'chart_of_account_card_id' => $cashier_out->category->chart_of_account_card_id,

                'debit' => 0,
                'credit' => $cashier_out->total,
            ]);
        }

        if ($cashier_out->chart_of_account_id) {
            $journal->items()->create([
                'locked_by_journal' => true,

                'chart_of_account_id' => $cashier_out->chart_of_account_id,
                'chart_of_account_card_id' => null,

                'debit' => $cashier_out->total,
                'credit' => 0,
            ]);
        }
    }

    public static function updateFromCashierIn(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier__fac, update_from_cashier_in');
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

        if ($cashier_in->category->chart_of_account_id) {
            $cashier_in->journal->items()->create([
                'locked_by_journal' => true,

                'chart_of_account_id' => $cashier_in->category->chart_of_account_id,
                'chart_of_account_card_id' => $cashier_in->category->chart_of_account_card_id,

                'debit' => $cashier_in->total,
                'credit' => 0,
            ]);
        }
    }

    public static function updateFromCashierOut(CashierOut $cashier_out)
    {
        $log = applog('erp, pra_gl_cashier__fac, update_from_cashier_out');
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

        if ($cashier_out->category->chart_of_account_id) {
            $cashier_out->journal->items()->create([
                'locked_by_journal' => true,

                'chart_of_account_id' => $cashier_out->category->chart_of_account_id,
                'chart_of_account_card_id' => $cashier_out->category->chart_of_account_card_id,

                'debit' => 0,
                'credit' => $cashier_out->total,
            ]);
        }

        if ($cashier_out->chart_of_account_id) {
            $cashier_out->journal->items()->create([
                'locked_by_journal' => true,

                'chart_of_account_id' => $cashier_out->chart_of_account_id,
                'chart_of_account_card_id' => null,

                'debit' => $cashier_out->total,
                'credit' => 0,
            ]);
        }
    }

    public static function updateOrCreateFromCashierIn(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier__fac, update_or_create_from_cashier_in');
        $log->save('debug');

        if ($cashier_in->journal) {
            static::updateFromCashierIn($cashier_in);
        } else {
            static::createFromCashierIn($cashier_in);
        }
    }

    public static function updateOrCreateFromCashierOut(CashierOut $cashier_out)
    {
        $log = applog('erp, pra_gl_cashier__fac, update_or_create_from_cashier_out');
        $log->save('debug');

        if ($cashier_out->journal) {
            static::updateFromCashierOut($cashier_out);
        } else {
            static::createFromCashierOut($cashier_out);
        }
    }

    public static function deleteFromCashierIn(CashierIn $cashier_in)
    {
        $log = applog('erp, pra_gl_cashier__fac, delete_from_cashier_in');
        $log->save('debug');

        if (!$cashier_in->journal) return;

        $cashier_in->journal->items()->delete();

        $cashier_in->journal->journal_ar_invoices()->delete();
        $cashier_in->journal->journal_ap_invoices()->delete();
        $cashier_in->journal->journal_cashier_ins()->delete();
        $cashier_in->journal->journal_cashier_outs()->delete();

        $cashier_in->journal->delete();
    }

    public static function deleteFromCashierOut(CashierOut $cashier_out)
    {
        $log = applog('erp, pra_gl_cashier__fac, delete_from_cashier_out');
        $log->save('debug');

        if (!$cashier_out->journal) return;

        $cashier_out->journal->items()->delete();

        $cashier_out->journal->journal_ar_invoices()->delete();
        $cashier_out->journal->journal_ap_invoices()->delete();
        $cashier_out->journal->journal_cashier_ins()->delete();
        $cashier_out->journal->journal_cashier_outs()->delete();

        $cashier_out->journal->delete();
    }
}
