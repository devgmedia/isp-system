<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\AccountingDivisionCategory;
use Gmedia\IspSystem\Models\AccountingMenu;
use Gmedia\IspSystem\Models\AccountingTransaction;
use Gmedia\IspSystem\Models\AccountingTransactionCoa;
use Gmedia\IspSystem\Models\ArInvoice;
use Gmedia\IspSystem\Models\Journal;
use Gmedia\IspSystem\Models\JournalCode;
use Gmedia\IspSystem\Models\JournalProject;
use Gmedia\IspSystem\Models\JournalType;

class PraGlAr
{
    public static function create(ArInvoice $ar_invoice)
    {
        $log = applog('erp, pra_gl_ar__fac, create');
        $log->save('debug');

        $umum_type_id = JournalType::where('name', 'Umum')->value('id');
        $umum_code_id = JournalCode::where('chart_of_account_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('type_id', $umum_type_id)
            ->value('id');
        $accounting_menu_id = AccountingMenu::where('name', 'pra gl ar')->value('id');
        $accounting_division_category_id = AccountingDivisionCategory::where('chart_of_account_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('default_on_pra_gl_ar', true)
            ->value('id');
        $journal_project_id = JournalProject::where('chart_of_account_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('default_on_pra_gl_ar', true)
            ->value('id');

        $journal = Journal::create([
            'date' => $ar_invoice->date,
            'auto_created' => true,
            'ar_invoice_id' => $ar_invoice->id,

            'branch_id' => $ar_invoice->branch_id,
            'chart_of_account_title_id' => $ar_invoice->chart_of_account_title_id,

            'code_id' => $umum_code_id,
            'menu_id' => $accounting_menu_id,
            'reference' => $ar_invoice->number,
            'description' => $ar_invoice->number.', '.$ar_invoice->date->format('Y-m-d').', '.$ar_invoice->payer_name.', '.$ar_invoice->payer_cid,
            'project_id' => $journal_project_id,
            'accounting_division_category_id' => $accounting_division_category_id,

            'submit' => false,
            'submit_at' => null,
            'submit_by' => null,

            'posted' => false,
            'posted_at' => null,
            'posted_by' => null,
        ]);

        // piutang
        $piutang_id = AccountingTransaction::leftJoin(
            'accounting_menu',
            'accounting_menu.id',
            '=',
            'accounting_transaction.menu_id',
        )
            ->where('accounting_transaction.name', 'piutang bandwidth')
            ->where('accounting_menu.name', 'pra gl ar')
            ->value('accounting_transaction.id');

        $piutang_coa_id = AccountingTransactionCoa::where('coa_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('transaction_id', $piutang_id)
            ->value('coa_id');

        $journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $piutang_coa_id,
            'chart_of_account_card_id' => null,

            'debit' => $ar_invoice->total,
            'credit' => 0,
        ]);

        // pendapatan
        $pendapatan_id = AccountingTransaction::leftJoin(
            'accounting_menu',
            'accounting_menu.id',
            '=',
            'accounting_transaction.menu_id',
        )
            ->where('accounting_transaction.name', 'pendapatan bandwidth')
            ->where('accounting_menu.name', 'pra gl ar')
            ->value('accounting_transaction.id');

        $pendapatan_coa_id = AccountingTransactionCoa::where('coa_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('transaction_id', $pendapatan_id)
            ->value('coa_id');

        $journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $pendapatan_coa_id,
            'chart_of_account_card_id' => null,

            'debit' => 0,
            'credit' => $ar_invoice->tax_base,
        ]);

        // ppn
        $ppn_id = AccountingTransaction::leftJoin(
            'accounting_menu',
            'accounting_menu.id',
            '=',
            'accounting_transaction.menu_id',
        )
            ->where('accounting_transaction.name', 'ppn')
            ->where('accounting_menu.name', 'pra gl ar')
            ->value('accounting_transaction.id');

        $ppn_coa_id = AccountingTransactionCoa::where('coa_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('transaction_id', $ppn_id)
            ->value('coa_id');

        $journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $ppn_coa_id,
            'chart_of_account_card_id' => null,

            'debit' => 0,
            'credit' => $ar_invoice->tax,
        ]);
    }

    public static function update(ArInvoice $ar_invoice)
    {        
        $log = applog('erp, pra_gl_ar__fac, update');
        $log->save('debug');

        $umum_type_id = JournalType::where('name', 'Umum')->value('id');
        $umum_code_id = JournalCode::where('chart_of_account_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('type_id', $umum_type_id)
            ->value('id');
        $accounting_menu_id = AccountingMenu::where('name', 'pra gl ar')->value('id');
        $accounting_division_category_id = AccountingDivisionCategory::where('chart_of_account_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('default_on_pra_gl_ar', true)
            ->value('id');
        $journal_project_id = JournalProject::where('chart_of_account_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('default_on_pra_gl_ar', true)
            ->value('id');

        $ar_invoice->journal->update([
            'date' => $ar_invoice->date,
            'auto_created' => true,
            'ar_invoice_id' => $ar_invoice->id,

            'branch_id' => $ar_invoice->branch_id,
            'chart_of_account_title_id' => $ar_invoice->chart_of_account_title_id,

            'code_id' => $umum_code_id,
            'menu_id' => $accounting_menu_id,
            'reference' => $ar_invoice->number,
            'description' => $ar_invoice->number.', '.$ar_invoice->date->format('Y-m-d').', '.$ar_invoice->payer_name,
            'project_id' => $journal_project_id,
            'accounting_division_category_id' => $accounting_division_category_id,

            'submit' => false,
            'submit_at' => null,
            'submit_by' => null,

            'posted' => false,
            'posted_at' => null,
            'posted_by' => null,
        ]);

        $ar_invoice->journal->items()->where('locked_by_journal', true)->delete();

        // piutang
        $piutang_id = AccountingTransaction::leftJoin(
            'accounting_menu',
            'accounting_menu.id',
            '=',
            'accounting_transaction.menu_id',
        )
            ->where('accounting_transaction.name', 'piutang bandwidth')
            ->where('accounting_menu.name', 'pra gl ar')
            ->value('accounting_transaction.id');

        $piutang_coa_id = AccountingTransactionCoa::where('coa_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('transaction_id', $piutang_id)
            ->value('coa_id');

        $ar_invoice->journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $piutang_coa_id,
            'chart_of_account_card_id' => null,

            'debit' => $ar_invoice->total,
            'credit' => 0,
        ]);

        // pendapatan
        $pendapatan_id = AccountingTransaction::leftJoin(
            'accounting_menu',
            'accounting_menu.id',
            '=',
            'accounting_transaction.menu_id',
        )
            ->where('accounting_transaction.name', 'pendapatan bandwidth')
            ->where('accounting_menu.name', 'pra gl ar')
            ->value('accounting_transaction.id');

        $pendapatan_coa_id = AccountingTransactionCoa::where('coa_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('transaction_id', $pendapatan_id)
            ->value('coa_id');

        $ar_invoice->journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $pendapatan_coa_id,
            'chart_of_account_card_id' => null,

            'debit' => 0,
            'credit' => $ar_invoice->tax_base,
        ]);

        // ppn
        $ppn_id = AccountingTransaction::leftJoin(
            'accounting_menu',
            'accounting_menu.id',
            '=',
            'accounting_transaction.menu_id',
        )
            ->where('accounting_transaction.name', 'ppn')
            ->where('accounting_menu.name', 'pra gl ar')
            ->value('accounting_transaction.id');

        $ppn_coa_id = AccountingTransactionCoa::where('coa_title_id', $ar_invoice->chart_of_account_title_id)
            ->where('transaction_id', $ppn_id)
            ->value('coa_id');

        $ar_invoice->journal->items()->create([
            'locked_by_journal' => true,

            'chart_of_account_id' => $ppn_coa_id,
            'chart_of_account_card_id' => null,

            'debit' => 0,
            'credit' => $ar_invoice->tax,
        ]);
    }
    
    public static function updateOrCreate(ArInvoice $ar_invoice)
    {
        $log = applog('erp, pra_gl_ar__fac, update_or_create');
        $log->save('debug');

        if ($ar_invoice->journal) {
            static::update($ar_invoice);
        } else {
            static::create($ar_invoice);
        }
    }

    public static function delete(ArInvoice $ar_invoice)
    {
        $log = applog('erp, pra_gl_ar__fac, delete');
        $log->save('debug');

        if (!$ar_invoice->journal) return;

        $ar_invoice->journal->items()->delete();
        
        $ar_invoice->journal->journal_ar_invoices()->delete();
        $ar_invoice->journal->journal_ap_invoices()->delete();
        $ar_invoice->journal->journal_ar_invoices()->delete();
        $ar_invoice->journal->journal_cashier_outs()->delete();

        $ar_invoice->journal->delete();
    }
}
