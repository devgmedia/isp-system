<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ArInvoice;
use Gmedia\IspSystem\Models\TaxOut as TaxOutModel;

class TaxOut
{
    public static function create(ArInvoice $invoice)
    {
        $log = applog('erp, tax_out__fac, create');
        $log->save('debug');

        $tax_out = TaxOutModel::create([
            'ar_invoice_id' => $invoice->id,
            'branch_id' => $invoice->branch_id,
            'chart_of_account_title_id' => $invoice->chart_of_account_title_id,

            'customer_id' => $invoice->payer,
            'invoice_date' => $invoice->date,
            'customer_name' => $invoice->payer_name,
            'invoice_uuid' => $invoice->uuid,
            'invoice_number' => $invoice->number,
            'customer_uuid' => $invoice->payer_ref->uuid,
            'cid' => $invoice->payer_cid,
            'invoice_ppn' => $invoice->tax,
            'invoice_dpp' => $invoice->tax_base,
            'npwp' => $invoice->payer_ref->npwp,
            'brand_id' => $invoice->brand_id,
            'customer_address' => $invoice->payer_ref->address,
            'faktur_id' => $invoice->faktur_id,
        ]);

        return $tax_out;
    }

    public static function delete(ArInvoice $invoice)
    {
        $log = applog('erp, tax_out__fac, delete');
        $log->save('debug');

        $tax_out = $invoice->tax_out;
        if ($tax_out) {
            $tax_out->delete();
        }

        return true;
    }
}
