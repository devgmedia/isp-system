<?php

namespace Gmedia\IspSystem\Facades;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\ApInvoice as ApInvoiceModel;
use Gmedia\IspSystem\Models\ArInvoice;
use Gmedia\IspSystem\Models\TaxIn;

class ApInvoice
{
    public static function createMemo(ArInvoice $ar_invoice)
    {
        $log = applog('erp, ap_invoice__fac, create_memo');
        $log->save('debug');

        $tax_rate = 10;
        if ($ar_invoice->date->gte(Carbon::create(2022, 4, 1, 0))) {
            $tax_rate = 11;
        }
        if ($ar_invoice->tax_rate) {
            $tax_rate = $ar_invoice->tax_rate;
        }
        if (! $ar_invoice->is_tax) {
            $tax_rate = 0;
        }

        $ap_invoice = [
            'name' => $ar_invoice->name,
            'date' => $ar_invoice->date,
            'due_date' => $ar_invoice->due_date,
            'received_date' => $ar_invoice->date,
            'invoice_number' => $ar_invoice->number,

            'stamp_duty' => 0,

            'branch_id' => $ar_invoice->branch_id,
            'chart_of_account_title_id' => $ar_invoice->chart_of_account_title_id,

            'memo' => true,
            'memo_ar_invoice_id' => $ar_invoice->id,
        ];

        $default_item = [
            'name' => null,
            'po_category_id' => null,
            'pr_category_id' => null,
            'price' => 0.0,
            'discount' => 0.0,
            'retention' => 0.0,
            'tax' => 0.0,
            'pph_pasal_21' => 0.0,
            'pph_pasal_23' => 0.0,
            'pph_pasal_4_ayat_2' => 0.0,
            'pph_pasal_26' => 0.0,
        ];
        $items = [];

        $ar_invoice->load([
            'invoice_customers',
            'invoice_customers.invoice_customer_products',
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals',
            'invoice_customers.invoice_customer_products.invoice_customer_product_discounts',
        ]);
        $ar_invoice->invoice_customers
            ->each(function ($invoice_customer) use ($default_item, &$items, $tax_rate) {
                $invoice_customer->invoice_customer_products
                    ->each(function ($invoice_customer_product) use ($default_item, &$items, $tax_rate) {
                        array_push($items, array_merge($default_item, [
                            'name' => $invoice_customer_product->product_name,
                            'price' => $invoice_customer_product->total,
                            'tax' => $invoice_customer_product->total * $tax_rate / 100,
                            'ar_invoice_customer_product_id' => $invoice_customer_product->id,
                        ]));

                        $invoice_customer_product
                            ->invoice_customer_product_additionals
                            ->each(function ($invoice_customer_product_additional) use ($default_item, &$items, $tax_rate) {
                                array_push($items, array_merge($default_item, [
                                    'name' => $invoice_customer_product_additional->product_name,
                                    'price' => $invoice_customer_product_additional->total,
                                    'tax' => $invoice_customer_product_additional->total * $tax_rate / 100,
                                    'ar_invoice_customer_product_additional_id' => $invoice_customer_product_additional->id,
                                ]));
                            });

                        $invoice_customer_product
                            ->invoice_customer_product_discounts
                            ->each(function ($invoice_customer_product_discount) use ($default_item, &$items) {
                                array_push($items, array_merge($default_item, [
                                    'name' => $invoice_customer_product_discount->discount_name,
                                    'price' => $invoice_customer_product_discount->total,
                                    'ar_invoice_customer_product_discount_id' => $invoice_customer_product_discount->id,
                                ]));
                            });
                    });
            });

        $price = 0.0;
        $discount = 0.0;
        $retention = 0.0;
        $tax_base = 0.0;
        $tax = 0.0;
        $pph_pasal_21 = 0.0;
        $pph_pasal_23 = 0.0;
        $pph_pasal_4_ayat_2 = 0.0;
        $pph_pasal_26 = 0.0;
        $total_without_pph = 0.0;
        $total = 0.0;

        $items = collect($items)->map(function ($item) use (
            &$price,
            &$discount,
            &$retention,
            &$tax_base,
            &$tax,
            &$pph_pasal_21,
            &$pph_pasal_23,
            &$pph_pasal_4_ayat_2,
            &$pph_pasal_26,
            &$total_without_pph,
            &$total
        ) {
            $price += $item['price'];
            $discount += $item['discount'];
            $retention += $item['retention'];

            $item['tax_base'] = $item['price'] - $item['discount'] - $item['retention'];
            $tax_base += $item['tax_base'];

            $tax += $item['tax'];

            $item['total_without_pph'] = $item['tax_base'] + $item['tax'];
            $total_without_pph += $item['total_without_pph'];

            $pph_pasal_21 += $item['pph_pasal_21'];
            $pph_pasal_23 += $item['pph_pasal_23'];
            $pph_pasal_4_ayat_2 += $item['pph_pasal_4_ayat_2'];
            $pph_pasal_26 += $item['pph_pasal_26'];

            $item['total'] = $item['total_without_pph'] + $item['pph_pasal_21'] + $item['pph_pasal_23'] + $item['pph_pasal_4_ayat_2'] + $item['pph_pasal_26'];
            $total += $item['total'];

            return $item;
        })->all();

        $ap_invoice['price'] = $price;
        $ap_invoice['discount'] = $discount;
        $ap_invoice['retention'] = $retention;
        $ap_invoice['tax_base'] = $tax_base;
        $ap_invoice['tax'] = $tax;
        $ap_invoice['pph_pasal_21'] = $pph_pasal_21;
        $ap_invoice['pph_pasal_23'] = $pph_pasal_23;
        $ap_invoice['pph_pasal_4_ayat_2'] = $pph_pasal_4_ayat_2;
        $ap_invoice['pph_pasal_26'] = $pph_pasal_26;
        $ap_invoice['total_without_pph'] = $total_without_pph;
        $ap_invoice['total'] = $total + $ap_invoice['stamp_duty'];

        $ap_invoice = ApInvoiceModel::create($ap_invoice);
        $ap_invoice->items()->createMany($items);

        $ap_invoice->refresh();
        TaxIn::create($ap_invoice);
    }

    public static function createFromTaxIn(TaxIn $tax_in)
    {
        $log = applog('erp, ap_invoice__fac, create_from_tax_in');
        $log->save('debug');

        $ap_invoice = [
            'name' => 'Tax',
            'date' => Carbon::now()->toDateString(),
            'due_date' => Carbon::now()->toDateString(),

            'stamp_duty' => 0,

            'branch_id' => $tax_in->branch_id,
            'chart_of_account_title_id' => $tax_in->chart_of_account_title_id,
        ];
        $ap_invoice = ApInvoiceModel::create($ap_invoice);

        $tax_in->ap_invoice_id = $ap_invoice->id;
        $tax_in->save();

        $total_without_pph = $tax_in->ppn;
        $total = $tax_in->ppn
            + $tax_in->pph_pasal_21
            + $tax_in->pph_pasal_23
            + $tax_in->pph_pasal_4_ayat_2
            + $tax_in->pph_pasal_25
            + $tax_in->pph_pasal_26;

        $ap_invoice_item = [
            'name' => 'Tax',

            'tax' => $tax_in->ppn,
            'pph_pasal_21' => $tax_in->pph_pasal_21,
            'pph_pasal_23' => $tax_in->pph_pasal_23,
            'pph_pasal_4_ayat_2' => $tax_in->pph_pasal_4_ayat_2,
            'pph_pasal_25' => $tax_in->pph_pasal_25,
            'pph_pasal_26' => $tax_in->pph_pasal_26,

            'total_without_pph' => $total_without_pph,
            'total' => $total,
        ];

        $ap_invoice_item = $ap_invoice->items()->create($ap_invoice_item);

        $ap_invoice->update([
            'tax' => $ap_invoice_item->tax,
            'pph_pasal_21' => $ap_invoice_item->pph_pasal_21,
            'pph_pasal_23' => $ap_invoice_item->pph_pasal_23,
            'pph_pasal_4_ayat_2' => $ap_invoice_item->pph_pasal_4_ayat_2,
            'pph_pasal_25' => $ap_invoice_item->pph_pasal_25,
            'pph_pasal_26' => $ap_invoice_item->pph_pasal_26,

            'total_without_pph' => $ap_invoice_item->total_without_pph,
            'total' => $ap_invoice_item->total,
        ]);
    }
}
