<?php

namespace Gmedia\IspSystem\Facades;

use Illuminate\Support\Facades\DB;

class ChartOfAccount
{
    public static function getIdByTransaction(
        $transaction_name = null,
        $branch_id = null
    )
    {
        $accounting_transaction_coa_query = DB::table('accounting_transaction_coa')
            ->select(
                'accounting_transaction_coa.id',
                'accounting_transaction_coa.coa_id',
                'accounting_transaction.name as transaction_name',
            )
            ->leftJoin('accounting_transaction', 'accounting_transaction.id', '=', 'accounting_transaction_coa.transaction_id');

        return DB::table('chart_of_account')
            ->leftJoinSub($accounting_transaction_coa_query, 'accounting_transaction_coa', function ($join) {
                $join->on('accounting_transaction_coa.coa_id', '=', 'chart_of_account.id');
            })
            ->leftJoin('chart_of_account_title', 'chart_of_account_title.id', '=', 'chart_of_account.title_id')
            ->where('accounting_transaction_coa.transaction_name', $transaction_name)
            ->where('chart_of_account_title.branch_id', $branch_id)
            ->orderByDesc('chart_of_account_title.effective_date')
            ->value('chart_of_account.id');
    }
}
