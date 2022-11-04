<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ArInvoice;
use Gmedia\IspSystem\Models\ArInvoiceSettlement as ArInvoiceSettlementModel;

class ArInvoiceSettlement
{
    public static function updateIndexes(ArInvoiceSettlementModel $settlement)
    {
        $log = applog('erp, ar_invoice_settlement__fac, update_indexes');
        $log->save('debug');

        // settlement indexes
        $invoice = $settlement->ar_invoice;

        if ($invoice) {
            $settlement->brand_id = $invoice->brand_id;
            $settlement->memo = $invoice->memo;
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

            $invoice->refresh();
            self::updateInvoiceIndexes($invoice);
        }

        return $settlement;
    }

    public static function updateInvoiceIndexes(ArInvoice $invoice)
    {
        $log = applog('erp, ar_invoice_settlement__fac, update_invoice_indexes');
        $log->save('debug');

        $paid = false;
        $paid_total = 0;

        $settlement_invoice = 0;
        $settlement_admin = 0;
        $settlement_down_payment = 0;
        $settlement_marketing_fee = 0;
        $settlement_pph_pasal_22 = 0;
        $settlement_pph_pasal_23 = 0;
        $settlement_ppn = 0;

        $invoice->settlements
            ->each(function ($ar_invoice_settlement) use (
                &$paid_total,
    
                &$settlement_invoice,
                &$settlement_admin,
                &$settlement_down_payment,
                &$settlement_marketing_fee,
                &$settlement_pph_pasal_22,
                &$settlement_pph_pasal_23,
                &$settlement_ppn
            ) {                   
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
}
