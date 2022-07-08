<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ArInvoice;
use Gmedia\IspSystem\Models\ArInvoiceSettlement as ArInvoiceSettlementModel;
use Gmedia\IspSystem\Models\Spm;

class ArInvoiceSettlement
{
    public static function updateIndexes(ArInvoiceSettlementModel $settlement)
    {
        $log = applog('erp, ar_invoice_settlement__fac, update_indexes');
        $log->save('debug');

        // settlement indexes
        $invoice = null;
        $ar_invoice_settlement_invoice = $settlement->ar_invoice_settlement_invoices->first();
        
        if ($ar_invoice_settlement_invoice) {
            $invoice = $ar_invoice_settlement_invoice->ar_invoice;
        }

        if ($invoice) {
            $settlement->brand_id = $invoice->brand_id;
            $settlement->memo_to = $invoice->memo_to;
            $settlement->invoice_number = $invoice->number;
            $settlement->sid = $invoice->sid;
            $settlement->cid = $invoice->payer_cid;
            $settlement->customer_name = $invoice->payer_name;
            $settlement->product_id = $invoice->product_id;
            $settlement->customer_category_id = $invoice->customer_category_id;
            $settlement->receiver = $invoice->billing_preparer;
            $settlement->received_from = $invoice->receiver_name;

            $invoice_customer = $invoice->invoice_customers->first();
            $invoice_customer_product = $invoice_customer->invoice_customer_products->first();
            $settlement->product_name = $invoice_customer_product->product_name;

            $settlement->receiver_address = $settlement->branch->billing_address;
            $settlement->receiver_city = $settlement->branch->billing_city;

            $settlement->save();
        }

        // update invoice indexes
        $settlement->invoices->each(function ($invoice) {
            self::updateInvoiceIndexes($invoice);
        });

        return $settlement;
    }

    public static function updateInvoiceIndexes(ArInvoice $invoice)
    {
        $log = applog('erp, ar_invoice_settlement__fac, update_invoice_indexes');
        $log->save('debug');

        $multiple_invoice_on_settlement_found = false;

        $paid = false;
        $paid_total = 0;

        $settlement_invoice = 0;
        $settlement_admin = 0;
        $settlement_down_payment = 0;
        $settlement_marketing_fee = 0;
        $settlement_pph_pasal_22 = 0;
        $settlement_pph_pasal_23 = 0;
        $settlement_ppn = 0;

        $invoice->ar_invoice_settlement_invoices
            ->each(function ($ar_invoice_settlement_invoice) use (
                &$multiple_invoice_on_settlement_found,
                &$paid_total,
    
                &$settlement_invoice,
                &$settlement_admin,
                &$settlement_down_payment,
                &$settlement_marketing_fee,
                &$settlement_pph_pasal_22,
                &$settlement_pph_pasal_23,
                &$settlement_ppn
            ) {
                $ar_invoice_settlement = $ar_invoice_settlement_invoice->ar_invoice_settlement;
                if (!$ar_invoice_settlement) return true;

                if ($ar_invoice_settlement->ar_invoice_settlement_invoices->count() > 1) {
                    $multiple_invoice_on_settlement_found = true;
                }
                   
                $paid_total += $ar_invoice_settlement->total;

                $settlement_invoice += $ar_invoice_settlement->invoice;
                $settlement_admin += $ar_invoice_settlement->admin;
                $settlement_down_payment += $ar_invoice_settlement->down_payment;
                $settlement_marketing_fee += $ar_invoice_settlement->marketing_fee;
                $settlement_pph_pasal_22 += $ar_invoice_settlement->pph_pasal_22;
                $settlement_pph_pasal_23 += $ar_invoice_settlement->pph_pasal_23;
                $settlement_ppn += $ar_invoice_settlement->ppn;                           
            });

        if ($paid_total >= $invoice->total) {
            $paid = true;
        }

        $invoice->update([
            'paid' => $paid,
            'paid_total' => $paid_total,
            
            'settlement_invoice' => $settlement_invoice,
            'settlement_admin' => $settlement_admin,
            'settlement_down_payment' => $settlement_down_payment,
            'settlement_marketing_fee' => $settlement_marketing_fee,
            'settlement_pph_pasal_22' => $settlement_pph_pasal_22,
            'settlement_pph_pasal_23' => $settlement_pph_pasal_23,
            'settlement_ppn' => $settlement_ppn,
        ]);
    }

    public static function createFromSpm(Spm $spm)
    {
		$log = applog('erp, ar_invoice_settlement__fac, create_from_spm');
        $log->save('debug');

        $ap_invoice = $spm->invoice;
        if (!$ap_invoice) {
            $log->save('AP not found');
            return false;
        }

        $ar_invoice = $ap_invoice->memo_ar_invoice;
        if (!$ar_invoice) {
            $log->save('AR not found');
            return false;
        }

        $ar_invoice_settlement = [
            'date' => $spm->date,

            'invoice' => 0.0,
            'admin' => 0.0,
            'down_payment' => 0.0,
            'marketing_fee' => 0.0,
            'pph_pasal_22' => 0.0,
            'pph_pasal_23' => 0.0,
            'ppn' => 0.0,
            'total' => 0.0,

            'branch_id' => $spm->branch_id,
            'chart_of_account_title_id' => $spm->chart_of_account_title_id,

            'spm_id' => $spm->id,
        ];

        $ar_invoice_settlement_obj = ArInvoiceSettlementModel::create($ar_invoice_settlement);
        $ar_invoice_settlement_obj->ar_invoice_settlement_invoices()->create([
            'ar_invoice_id' => $ar_invoice->id,
        ]);

        $ar_invoice_settlement_obj->refresh();
        static::updateIndexes($ar_invoice_settlement_obj);
    }
}
