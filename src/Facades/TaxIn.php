<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ApInvoice;
use Gmedia\IspSystem\Models\TaxIn as TaxInModel;

class TaxIn
{
    public static function create(ApInvoice $invoice)
    {
        $log = applog('erp, tax_in__fac, create');
        $log->save('debug');

        $tax_in = TaxInModel::create([
            'ap_invoice_id' => $invoice->id,
            'branch_id' => $invoice->branch_id,
            'chart_of_account_title_id' => $invoice->chart_of_account_title_id,

            'supplier_id' => $invoice->supplier_id,
            'invoice_date' => $invoice->date,
            'supplier_name' => $invoice->supplier_id ? $invoice->supplier->name : null,
        ]);

        return $tax_in;
    }

    public static function delete(ApInvoice $invoice)
    {
        $log = applog('erp, tax_in__fac, delete');
        $log->save('debug');

        $tax_in = $invoice->tax_in;
        if ($tax_in) {
            $tax_in->delete();
        }

        return true;
    }
}
