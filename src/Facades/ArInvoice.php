<?php

namespace Gmedia\IspSystem\Facades;

use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use Endroid\QrCode\QrCode as EndroidQrCode;
use Endroid\QrCode\Writer\PngWriter;
use Gmedia\IspSystem\Facades\Calculate as CalculateFac;
use Gmedia\IspSystem\Facades\Mail as MailFac;
use Gmedia\IspSystem\Facades\ZipStream as ZipStreamFac;
use Gmedia\IspSystem\Jobs\ArInvoiceCreateAndSendPdfReceiptWhatsapp;
use Gmedia\IspSystem\Jobs\ArInvoiceCreatePdf;
use Gmedia\IspSystem\Jobs\ArInvoiceCreatePdfReceipt;
use Gmedia\IspSystem\Jobs\ArInvoiceCreatePdfRetailInternet;
use Gmedia\IspSystem\Jobs\MidtransGetStatus;
use Gmedia\IspSystem\Mail\ArInvoice\Mail as Mailable;
use Gmedia\IspSystem\Mail\ArInvoice\ReceiptMail;
use Gmedia\IspSystem\Mail\ArInvoice\ReminderMail;
use Gmedia\IspSystem\Models\ArInvoice as ArInvoiceModel;
use Gmedia\IspSystem\Models\ArInvoiceLog;
use Gmedia\IspSystem\Models\ArInvoiceMidtrans;
use Gmedia\IspSystem\Models\ArInvoiceScheme as ArInvoiceSchemeModel;
use Gmedia\IspSystem\Models\ArInvoiceWhatsappReceipt;
use Gmedia\IspSystem\Models\ArInvoiceWhatsappReminder;
use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\ChartOfAccountTitle;
use Gmedia\IspSystem\Models\Customer as CustomerModel;
use Gmedia\IspSystem\Models\CustomerProduct;
use Gmedia\IspSystem\Models\CustomerProductAdditional;
use Gmedia\IspSystem\Models\ProductBrand;
use Gmedia\IspSystem\Models\ProductBrandType;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use niklasravnsborg\LaravelPdf\PdfWrapper;
use Spatie\Period\Period;
use STS\ZipStream\ZipStreamFacade as ZipStream;

class ArInvoice
{
    public static function generateNumber(Branch $branch, $billing_date)
    {
        $log = applog('erp, ar_invoice__fac, generate_number');
        $log->save('debug');

        $number = null;

        $last_invoice = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                'ar_invoice.number',
            )
            ->where('ar_invoice.branch_id', $branch->id)
            ->whereMonth('ar_invoice.billing_date', $billing_date->month)
            ->whereYear('ar_invoice.billing_date', $billing_date->year)
            ->orderBy('ar_invoice.created_at', 'desc')
            ->first();

        $last_number = $last_invoice ? $last_invoice->number : null;

        if ($last_number) {
            $explode_last_number = explode('/', $last_number);
            $number = $explode_last_number[0].'/'.$explode_last_number[1].'/'.$explode_last_number[2].'/'.sprintf('%04d', intval($explode_last_number[3]) + 1);
        }

        if (! $number) {
            $number = 'INV/'.$branch->code.'/'.$billing_date->format('my').'/'.'0001';
        }

        while (DB::table('ar_invoice')->where('number', $number)->exists()) {
            $explode_number = explode('/', $number);
            $number = $explode_number[0].'/'.$explode_number[1].'/'.$explode_number[2].'/'.sprintf('%04d', intval($explode_number[3]) + 1);
        }

        return $number;
    }

    public static function enterpriseGenerateNumber(CustomerModel $customer)
    {
        $log = applog('erp, ar_invoice__fac, enterprise_generate_number');
        $log->save('debug');

        $number = null;

        $last_invoice = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                'ar_invoice.number',
            )
            ->where('ar_invoice.payer', $customer->id)
            ->orderBy('ar_invoice.id', 'desc')
            ->first();

        $last_number = $last_invoice ? $last_invoice->number : null;

        if ($last_number) {
            $explode_last_number = explode('/', $last_number);
            $explode_last_segment = explode('.', $explode_last_number[2]);

            $number = $explode_last_number[0].'/'.$explode_last_number[1].'/'.sprintf('%03d', intval($explode_last_segment[0]) + 1).'.'.$explode_last_segment[1];
        } else {
            $number = 'INV/'
                .substr($customer->cid, 0, 2).'.'.substr($customer->cid, 2, 4).'/'
                .sprintf('%03d', $customer->invoice_increment + 1).'.'.Carbon::now()->format('my');
        }

        return $number;
    }

    public static function create(ArInvoiceSchemeModel $scheme, $date, $billing_date, $created_by_cron = false, $number = null, $uuid = null)
    {
        $log = applog('erp, ar_invoice__fac, create');
        $log->save('debug');

        if (
            $scheme->payer_ref &&
            $scheme->payer_ref->brand &&
            $scheme->payer_ref->brand->type &&
            $scheme->payer_ref->brand->type->name !== 'Retail Internet Service'
        ) {
            return;
        }

        $date = $date->toImmutable();
        $billing_date = $billing_date->toImmutable();

        if ($date->day > 28) {
            $date = $date->startOfMonth()->addMonthNoOverflow();
        }

        if ($billing_date->day > 28) {
            $billing_date = $billing_date->startOfMonth()->addMonthNoOverflow();
        }

        // installation
        $installation = Str::contains($scheme->name, 'Installation');

        // tax
        $tax_rate = 10;
        if ($date->gte(Carbon::create(2022, 4, 1, 0))) {
            $tax_rate = 11;
        }
        $log->save('tax_rate: '.$tax_rate);

        // customer_product
        $customer_product = null;

        if ($installation) {
            if ($scheme->invoices()->exists()) {
                return;
            }

            $customer_product = $scheme->scheme_customers->first()
                ->scheme_customer_product_additionals->first()
                ->customer_product_additional
                ->customer_product;
        } else {
            if (
                $scheme->invoices()
                ->whereMonth('billing_date', $billing_date->month)
                ->whereYear('billing_date', $billing_date->year)
                ->exists()
            ) {
                return;
            }

            $customer_product = $scheme->scheme_customers->first()
                ->scheme_customer_products->first()
                ->customer_product;
        }

        // product
        $product = null;
        if ($customer_product) {
            $product = $customer_product->product;
        }

        // subsidy
        $subsidy = false;
        if ($product && Str::contains($product->name, 'Subsidy')) {
            $subsidy = true;
        }

        // brand
        $brand = null;
        if ($product) {
            $brand = $product->brand;
        }

        // brand_type
        $brand_type = null;
        if ($brand) {
            $brand_type = $brand->type;
        }

        // agent
        $agent = null;
        if ($customer_product) {
            $agent = $customer_product->agent;
        }

        // sales
        $sales = null;
        if ($customer_product) {
            $sales = $customer_product->sales_ref;
        }

        // json_product_tag
        $json_product_tag = null;
        if ($customer_product && $customer_product->product) {
            $product_tags = [];

            $customer_product->product->tags->each(function ($tag) use (&$product_tags) {
                array_push($product_tags, ['id' => $tag->id]);
            });

            $json_product_tag = json_encode($product_tags);
        }

        // number
        if (! $number) {
            $number = static::generateNumber($scheme->payer_ref->branch, $billing_date);
        }

        $scheme->load([
            'scheme_customers',
            'scheme_customers.customer',
            'scheme_customers.customer.products',
            'scheme_customers.customer.products.brand',
            'scheme_customers.customer.products.billings',
            'scheme_customers.customer.products.billings.bank',
            'scheme_customers.customer.products.billings.receiver_ref',

            'scheme_customers.scheme_customer_products',
            'scheme_customers.scheme_customer_products.customer_product',
            'scheme_customers.scheme_customer_products.customer_product.product',
            'scheme_customers.scheme_customer_products.customer_product.product.payment_scheme',
            'scheme_customers.scheme_customer_products.customer_product.product.bandwidth_unit',
            'scheme_customers.scheme_customer_products.customer_product.product.bandwidth_type',
            'scheme_customers.scheme_customer_products.customer_product.customer_product_discounts',
            'scheme_customers.scheme_customer_products.customer_product.customer_product_discounts.product_discount',
            'scheme_customers.scheme_customer_products.customer_product.customer_product_discounts.product_discount.discount',
            'scheme_customers.scheme_customer_products.customer_product.agent',

            'scheme_customers.scheme_customer_products.scheme_customer_product_additionals',
            'scheme_customers.scheme_customer_products.scheme_customer_product_additionals.customer_product_additional',
            'scheme_customers.scheme_customer_products.scheme_customer_product_additionals.customer_product_additional.product_additional',
            'scheme_customers.scheme_customer_products.scheme_customer_product_additionals.customer_product_additional.product_additional.payment_scheme',
            'scheme_customers.scheme_customer_products.scheme_customer_product_additionals.customer_product_additional.product_additional.bandwidth_unit',
            'scheme_customers.scheme_customer_products.scheme_customer_product_additionals.customer_product_additional.product_additional.bandwidth_type',

            'scheme_customers.scheme_customer_product_additionals',
            'scheme_customers.scheme_customer_product_additionals.customer_product_additional',
            'scheme_customers.scheme_customer_product_additionals.customer_product_additional.product_additional',
            'scheme_customers.scheme_customer_product_additionals.customer_product_additional.product_additional.payment_scheme',
            'scheme_customers.scheme_customer_product_additionals.customer_product_additional.product_additional.bandwidth_unit',
            'scheme_customers.scheme_customer_product_additionals.customer_product_additional.product_additional.bandwidth_type',

            'payer_ref',
            'payer_ref.branch',
            'payer_ref.branch.regional',
        ]);
        $invoice = [
            'uuid' => $uuid,
            'ar_invoice_scheme_id' => $scheme->id,
            'number' => $number,
            'name' => $scheme->name,

            'ignore_tax' => $scheme->ignore_tax,
            'ignore_prorated' => $scheme->ignore_prorated,
            'postpaid' => $scheme->postpaid,
            'hybrid' => $scheme->hybrid,

            'created_by_cron' => $created_by_cron,
            'subsidy' => $subsidy,

            'branch_id' => $scheme->payer_ref->branch_id,
            'regional_id' => $scheme->payer_ref->branch->regional_id,
            'company_id' => $scheme->payer_ref->branch->regional->company_id,

            'chart_of_account_title_id' => $scheme
                ->payer_ref
                ->branch
                ->chart_of_account_titles()
                ->orderByDesc('effective_date')
                ->value('id'),
        ];

        // previous invoice
        $previous = ArInvoiceModel::where('ar_invoice_scheme_id', $scheme->id)
            ->orderBy('created_at')
            ->first();

        if ($previous) {
            $log->save('previous found');

            $invoice['previous'] = $previous->id;
            $invoice['previous_price'] = $previous->price;
            $invoice['previous_discount'] = $previous->discount;
            $invoice['previous_tax'] = $previous->tax;
            $invoice['previous_tax_base'] = $previous->tax_base;
            $invoice['previous_total'] = $previous->total;
            $invoice['previous_paid'] = $previous->paid;
        }

        // payer
        $payer = $scheme->payer_ref;

        $payer_phone_number = $payer->phone_numbers->first() ?
            $payer->phone_numbers->first()->number :
            null;
        $payer_email = $payer->emails->first() ?
            $payer->emails->first()->name :
            null;

        $invoice['payer'] = $payer->id;
        $invoice['payer_cid'] = $payer->cid;
        $invoice['payer_name'] = $payer->name;

        $invoice['payer_province_id'] = $payer->province_id;
        $invoice['payer_province_name'] = $payer->province_name;

        $invoice['payer_district_id'] = $payer->district_id;
        $invoice['payer_district_name'] = $payer->district_name;

        $invoice['payer_sub_district_id'] = $payer->sub_district_id;
        $invoice['payer_sub_district_name'] = $payer->sub_district_name;

        $invoice['payer_village_id'] = $payer->village_id;
        $invoice['payer_village_name'] = $payer->village_name;

        $invoice['payer_address'] = $payer->address;
        $invoice['payer_postal_code'] = $payer->postal_code;
        $invoice['payer_phone_number'] = $payer_phone_number;
        $invoice['payer_email'] = $payer_email;

        // receiver
        $payer = $scheme->payer_ref;
        $invoice['receiver_name'] = $payer->branch->regional->company->name;
        $invoice['receiver_address'] = $payer->branch->regional->address;
        $invoice['receiver_postal_code'] = $payer->branch->regional->postal_code;
        $invoice['receiver_phone_number'] = $payer->branch->regional->phone_number;
        $invoice['receiver_fax'] = $payer->branch->regional->fax;

        // billing information
        if ($scheme->scheme_customers->first()) {
            $first_product = $scheme->scheme_customers->first()->customer->products->first();
            $first_billing = $first_product->billings->first();

            $invoice['receiver_email'] = $first_billing->email;
            $invoice['billing_bank_id'] = $first_billing->bank_id;
            $invoice['billing_bank_name'] = $first_billing->bank->name;
            $invoice['billing_bank_account_number'] = $first_billing->bank_account_number;
            $invoice['billing_bank_account_on_behalf_of'] = $first_billing->bank_account_on_behalf_of;
            $invoice['billing_receiver'] = $first_billing->receiver;
            $invoice['billing_receiver_name'] = $first_billing->receiver_ref->name;
            $invoice['available_via_midtrans'] = $first_product->available_via_midtrans;
        }

        // date
        $due = $product->billing_time;
        $invoice['date'] = $date->toDateString();
        $invoice['due_date'] = $date->addDays($due)->toDateString();

        if ($scheme->hybrid && $scheme->postpaid) {
            $invoice['date'] = $date->subDays($due)->toDateString();
            $invoice['due_date'] = $date->toDateString();
        }

        // billing_date
        $invoice['billing_date'] = $billing_date->toDateString();

        // brand
        if ($brand) {
            $invoice['brand_id'] = $brand->id;
            $invoice['brand_name'] = $brand->name;

            if ($brand_type) {
                $invoice['brand_type_name'] = $brand_type->name;
            }
        }

        // product
        if ($product) {
            $invoice['product_id'] = $product->id;
            $invoice['product_name'] = $product->name;
        }

        // agent
        if ($agent) {
            $invoice['agent_id'] = $agent->id;
            $invoice['agent_name'] = $agent->name;
        }

        // sales
        if ($sales) {
            $invoice['sales'] = $sales->id;
        }

        // json_product_tag
        if ($json_product_tag) {
            $invoice['json_product_tag'] = $json_product_tag;
        }

        if ($customer_product) {
            $invoice['sid'] = $customer_product->sid;
            $invoice['billing_end_date'] = $customer_product->billing_end_date;
            $invoice['public_facility'] = $customer_product->public_facility;
            $invoice['price_include_tax'] = $customer_product->price_include_tax;
        }

        $invoice = ArInvoiceModel::create($invoice);

        // customer
        $scheme->scheme_customers->each(function ($scheme_customer) use ($invoice) {
            $invoice_customer = $invoice->invoice_customers()->create([
                'ar_invoice_scheme_customer_id' => $scheme_customer->id,

                'customer_id' => $scheme_customer->customer->id,
                'customer_cid' => $scheme_customer->customer->cid,
                'customer_name' => $scheme_customer->customer->name,

                'customer_province_id' => $scheme_customer->customer->province_id,
                'customer_province_name' => $scheme_customer->customer->province_name,

                'customer_district_id' => $scheme_customer->customer->district_id,
                'customer_district_name' => $scheme_customer->customer->district_name,

                'customer_sub_district_id' => $scheme_customer->customer->sub_district_id,
                'customer_sub_district_name' => $scheme_customer->customer->sub_district_name,

                'customer_village_id' => $scheme_customer->customer->village_id,
                'customer_village_name' => $scheme_customer->customer->village_name,

                'customer_address' => $scheme_customer->customer->address,
            ]);

            // product
            $scheme_customer->scheme_customer_products->each(function ($scheme_customer_product) use ($invoice_customer) {
                $product = $scheme_customer_product->customer_product->product;

                $product_name = $product->name;
                if ($scheme_customer_product->customer_product->adjusted_bandwidth) {
                    $product_name = $product_name.' '.
                        $scheme_customer_product->customer_product->special_bandwidth.' '.
                        $scheme_customer_product->customer_product->product->bandwidth_unit->name;
                }

                $invoice_customer_product = $invoice_customer->invoice_customer_products()->create([
                    'ar_invoice_scheme_customer_product_id' => $scheme_customer_product->id,

                    'customer_product_id' => $scheme_customer_product->customer_product->id,
                    'customer_product_name' => $product->name,
                    'customer_product_price' => $product->price,
                    'customer_product_price_include_tax' => $product->price_include_tax,

                    'customer_product_payment_scheme_id' => $product->payment_scheme_id,
                    'customer_product_payment_scheme_name' => $product->payment_scheme_id ? $product->payment_scheme->name : null,

                    'customer_product_bandwidth' => $product->bandwidth,
                    'customer_product_bandwidth_unit_id' => $product->bandwidth_unit_id,
                    'customer_product_bandwidth_unit_name' => $product->bandwidth_unit_id ? $product->bandwidth_unit->name : null,
                    'customer_product_bandwidth_type_id' => $product->bandwidth_type_id,
                    'customer_product_bandwidth_type_name' => $product->bandwidth_type_id ? $product->bandwidth_type->name : null,
                ]);

                // additional
                $scheme_customer_product->scheme_customer_product_additionals->each(function ($scheme_customer_product_additional) use ($invoice_customer_product) {
                    $additional = $scheme_customer_product_additional->customer_product_additional->product_additional;

                    $invoice_customer_product->invoice_customer_product_additionals()->create([
                        'ar_invoice_scheme_customer_product_additinal_id' => $scheme_customer_product_additional->id,

                        'customer_product_additional_id' => $scheme_customer_product_additional->customer_product_additional->id,
                        'customer_product_additional_name' => $additional->name,
                        'customer_product_additional_price' => $additional->price,
                        'customer_product_additional_price_include_tax' => $additional->price_include_tax,

                        'customer_product_additional_payment_scheme_id' => $additional->payment_scheme_id,
                        'customer_product_additional_payment_scheme_name' => $additional->payment_scheme_id ? $additional->payment_scheme->name : null,

                        'customer_product_additional_bandwidth' => $additional->bandwidth,
                        'customer_product_additional_bandwidth_unit_id' => $additional->bandwidth_unit_id,
                        'customer_product_additional_bandwidth_unit_name' => $additional->bandwidth_unit_id ? $additional->bandwidth_unit->name : null,
                        'customer_product_additional_bandwidth_type_id' => $additional->bandwidth_type_id,
                        'customer_product_additional_bandwidth_type_name' => $additional->bandwidth_type_id ? $additional->bandwidth_type->name : null,
                    ]);
                });

                // discount
                $scheme_customer_product->customer_product->customer_product_discounts->each(function ($customer_product_discount) use ($invoice_customer_product) {
                    $invoice_customer_product->invoice_customer_product_discounts()->create([
                        'customer_product_discount_id' => $customer_product_discount->id,
                        'customer_product_discount_name' => $customer_product_discount->product_discount->discount->name,
                    ]);
                });
            });

            // additional
            $scheme_customer->scheme_customer_product_additionals->each(function ($scheme_customer_product_additional) use ($invoice_customer) {
                $additional = $scheme_customer_product_additional->customer_product_additional->product_additional;

                $invoice_customer->invoice_customer_product_additionals()->create([
                    'ar_invoice_scheme_customer_product_additinal_id' => $scheme_customer_product_additional->id,

                    'customer_product_additional_id' => $scheme_customer_product_additional->customer_product_additional->id,
                    'customer_product_additional_name' => $additional->name,
                    'customer_product_additional_price' => $additional->price,
                    'customer_product_additional_price_include_tax' => $additional->price_include_tax,

                    'customer_product_additional_payment_scheme_id' => $additional->payment_scheme_id,
                    'customer_product_additional_payment_scheme_name' => $additional->payment_scheme_id ? $additional->payment_scheme->name : null,

                    'customer_product_additional_bandwidth' => $additional->bandwidth,
                    'customer_product_additional_bandwidth_unit_id' => $additional->bandwidth_unit_id,
                    'customer_product_additional_bandwidth_unit_name' => $additional->bandwidth_unit_id ? $additional->bandwidth_unit->name : null,
                    'customer_product_additional_bandwidth_type_id' => $additional->bandwidth_type_id,
                    'customer_product_additional_bandwidth_type_name' => $additional->bandwidth_type_id ? $additional->bandwidth_type->name : null,
                ]);
            });
        });

        // calculating
        $delete = true;

        $price = 0;
        $discount = 0;
        $tax_base = 0;
        $tax = 0;
        $total = 0;

        if ($scheme->postpaid) {
            // postpaid
            $log->save('postpaid');
            if ($scheme->ignore_prorated) {
                $log->save('ignore prorated');
                $billing_start_date = $billing_date->subMonthNoOverflow();
                $billing_end_date = $billing_date->subDay();
            } else {
                $billing_start_date = $billing_date->subMonthNoOverflow()->startOfMonth();
                $billing_end_date = $billing_date->subMonthNoOverflow()->endOfMonth();
            }
        } else {
            // prepaid
            $log->save('prepaid');
            if ($scheme->ignore_prorated) {
                $log->save('ignore prorated');
                $billing_start_date = $billing_date;
                $billing_end_date = $billing_date->addMonthNoOverflow()->subDay();
            } else {
                $billing_start_date = $billing_date->startOfMonth();
                $billing_end_date = $billing_date->endOfMonth();
            }
        }

        $invoice->load([
            'invoice_customers',
            'invoice_customers.invoice_customer_products',
            'invoice_customers.invoice_customer_products.customer_product',

            'invoice_customers.invoice_customer_products.invoice_customer_product_discounts',
            'invoice_customers.invoice_customer_products.invoice_customer_product_discounts.customer_product_discount',

            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals',
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals.customer_product_additional',

            'invoice_customers.invoice_customer_product_additionals',
            'invoice_customers.invoice_customer_product_additionals.customer_product_additional',
        ]);

        // customer
        foreach ($invoice->invoice_customers as $invoice_customer) {
            $log->save('looping customer');

            // product
            foreach ($invoice_customer->invoice_customer_products as $invoice_customer_product) {
                $log->save('looping product');

                $product_delete = true;

                $product_billing_start_date = $billing_start_date;
                $product_billing_end_date = $billing_end_date;

                $product_price = $invoice_customer_product->customer_product_price;
                $product_discount = 0;

                $product_price_after_discount = 0;

                // adjust quantity

                // adjust price
                if ($invoice_customer_product->customer_product->adjusted_price) {
                    $log->save('price adjusted');
                    $product_price = $invoice_customer_product->customer_product->special_price;
                }

                $sembako_full_period = 0;
                $sembako_period = 0;
                $hut_ri_76_discount = false;

                if ($invoice_customer_product->customer_product_payment_scheme_name === 'One Pay') {
                    $log->save('one pay');
                    $product_date = $invoice_customer_product->customer_product->billing_date ?
                        $invoice_customer_product->customer_product->billing_date->toImmutable() :
                        $product_billing_start_date;

                    $invoice_customer_product->update([
                        'billing_date' => $product_date->toDateString(),
                    ]);

                    $product_delete = false;
                    if (! $product_date->between($product_billing_start_date, $product_billing_end_date)) {
                        $log->save('delete status is true, not in billing period');
                        $product_delete = true;
                    }

                    if (Str::contains($invoice_customer_product->customer_product_name, '5 Bulan')) {
                        $log->save('5 Bulan');

                        $product_full_billing_period = Period::make(
                            $product_date->startOfMonth(),
                            $product_date->addMonthsNoOverflow(4)->endOfMonth(),
                        );

                        $product_period = Period::make(
                            $product_date,
                            $product_date->addMonthsNoOverflow(4)->endOfMonth(),
                        );

                        $product_billing_period = $product_full_billing_period->overlapAll($product_period);

                        $product_price = $product_price * $product_billing_period->length() / $product_full_billing_period->length();
                        $product_price_after_discount = $product_price - $product_discount;
                    } elseif (Str::contains($invoice_customer_product->customer_product_name, '9 Bulan')) {
                        $log->save('9 Bulan');

                        $product_full_billing_period = Period::make(
                            $product_date->startOfMonth(),
                            $product_date->addMonthsNoOverflow(8)->endOfMonth(),
                        );

                        $product_period = Period::make(
                            $product_date,
                            $product_date->addMonthsNoOverflow(8)->endOfMonth(),
                        );

                        $product_billing_period = $product_full_billing_period->overlapAll($product_period);

                        $product_price = $product_price * $product_billing_period->length() / $product_full_billing_period->length();
                        $product_price_after_discount = $product_price - $product_discount;
                    }
                } elseif ($invoice_customer_product->customer_product_payment_scheme_name === 'Monthly') {
                    $log->save('monthly');

                    $product_start_date = $invoice_customer_product->customer_product->billing_start_date ?
                        $invoice_customer_product->customer_product->billing_start_date->toImmutable() :
                        $product_billing_start_date;

                    $product_end_date = $invoice_customer_product->customer_product->billing_end_date ?
                        $invoice_customer_product->customer_product->billing_end_date->toImmutable() :
                        $product_billing_end_date;

                    $product_delete = false;

                    if (! $product_delete && $product_end_date->lt($product_billing_start_date)) {
                        $log->save('delete is true, end date less than billing start date');
                        $product_delete = true;
                    }

                    if (! $product_delete && $product_start_date->gt($product_billing_end_date)) {
                        $log->save('delete is true, start date greater than billing end date');
                        $product_delete = true;
                    }

                    if (! $product_delete && $product_end_date->lt($product_start_date)) { // dinonaktifkan sebelum dipakai
                        $log->save('delete is true, end date less than start date');
                        $product_delete = true;
                    }

                    if (! $product_delete) {
                        $product_full_billing_period = Period::make($product_billing_start_date, $product_billing_end_date);
                        $product_period = Period::make($product_start_date, $product_end_date);
                        $product_billing_period = $product_full_billing_period->overlapAll($product_period);

                        $product_price = $product_price * $product_billing_period->length() / $product_full_billing_period->length();

                        $sembako_full_period = $product_full_billing_period->length();
                        $sembako_period = $product_billing_period->length();

                        $invoice_customer_product->update([
                            'billing_start_date' => $product_billing_period->getStart()->format('Y-m-d'),
                            'billing_end_date' => $product_billing_period->getEnd()->format('Y-m-d'),
                        ]);
                    }
                }

                $product_price_after_discount = $product_price - $product_discount;

                // discount
                if (! $product_delete) {
                    foreach ($invoice_customer_product->invoice_customer_product_discounts as $invoice_customer_product_discount) {
                        $log->save('looping discount');

                        if ($invoice_customer_product_discount->customer_product_discount_name === 'Diskon 20% Dokter dan Tenaga Medis') {
                            $log->save('discount 20%');

                            $start_date = $invoice_customer_product_discount->customer_product_discount->start_date ?
                            $invoice_customer_product_discount->customer_product_discount->start_date->toImmutable() :
                            $product_billing_start_date;

                            $end_date = $invoice_customer_product_discount->customer_product_discount->end_date ?
                            $invoice_customer_product_discount->customer_product_discount->end_date->toImmutable() :
                            $product_billing_end_date;

                            if (! $invoice->billing_date->between($start_date, $end_date)) {
                                $log->new()->properties($invoice_customer_product_discount)->save('discount deleted');
                                $invoice_customer_product_discount->delete();

                                continue;
                            }

                            $product_discount += $product_price_after_discount * 20 / 100;
                            $product_price_after_discount = $product_price_after_discount - $product_discount;
                        } elseif ($invoice_customer_product_discount->customer_product_discount_name === 'Pay 75% HUT RI') {
                            $log->save('pay 75%');

                            $start_date = $invoice_customer_product_discount->customer_product_discount->start_date ?
                            $invoice_customer_product_discount->customer_product_discount->start_date->toImmutable() :
                            $product_billing_start_date;

                            $end_date = $invoice_customer_product_discount->customer_product_discount->end_date ?
                            $invoice_customer_product_discount->customer_product_discount->end_date->toImmutable() :
                            $product_billing_end_date;

                            if (! $invoice->billing_date->between($start_date, $end_date)) {
                                $log->new()->properties($invoice_customer_product_discount)->save('discount deleted');
                                $invoice_customer_product_discount->delete();

                                continue;
                            }

                            $product_discount += $product_price_after_discount * 25 / 100;
                            $product_price_after_discount = $product_price_after_discount - $product_discount;
                        } elseif ($invoice_customer_product_discount->customer_product_discount_name === 'Member Get Member, Free 1 Bulan') {
                            $log->save('promo member get member');

                            if (CustomerModel::where([
                                'referrer' => $scheme->payer_ref->id,
                                'referrer_used_for_discount' => false,
                            ])->count() >= 3) {
                                $log->save('promo executed');

                                CustomerModel::where([
                                    'referrer' => $scheme->payer_ref->id,
                                    'referrer_used_for_discount' => false,
                                ])->limit(3)->update([
                                    'referrer_used_for_discount' => true,
                                ]);

                                $product_discount += $product_price_after_discount * 100 / 100;
                                $product_price_after_discount = $product_price_after_discount - $product_discount;
                            }
                        } elseif ($invoice_customer_product_discount->customer_product_discount_name === 'Diskon Sembako 99rb') {
                            $log->save('discount 99rb');

                            $start_date = $invoice_customer_product_discount->customer_product_discount->start_date ?
                            $invoice_customer_product_discount->customer_product_discount->start_date->toImmutable() :
                            $product_billing_start_date;

                            $end_date = $invoice_customer_product_discount->customer_product_discount->end_date ?
                            $invoice_customer_product_discount->customer_product_discount->end_date->toImmutable() :
                            $product_billing_end_date;

                            if (! $invoice->billing_date->between($start_date, $end_date)) {
                                $log->new()->properties($invoice_customer_product_discount)->save('discount deleted');
                                $invoice_customer_product_discount->delete();

                                continue;
                            }

                            if ($sembako_full_period && $sembako_period) {
                                $log->save('discount executed');
                                $product_discount += 99000 * $sembako_period / $sembako_full_period;
                                $product_price_after_discount = $product_price_after_discount - $product_discount;
                            }
                        } elseif ($invoice_customer_product_discount->customer_product_discount_name === 'Get 1 Member, Free 1 Bulan') {
                            $log->save('promo get 1 member');

                            if (CustomerModel::where([
                                'referrer' => $scheme->payer_ref->id,
                                'referrer_used_for_discount' => false,
                            ])->count() >= 1) {
                                $log->save('promo executed');

                                CustomerModel::where([
                                    'referrer' => $scheme->payer_ref->id,
                                    'referrer_used_for_discount' => false,
                                ])->limit(1)->update([
                                    'referrer_used_for_discount' => true,
                                ]);

                                $product_discount += $product_price_after_discount * 100 / 100;
                                $product_price_after_discount = $product_price_after_discount - $product_discount;
                            }
                        } elseif ($invoice_customer_product_discount->customer_product_discount_name === 'HUT RI 76') {
                            $log->save('hut ri 76');

                            $start_date = $invoice_customer_product_discount->customer_product_discount->start_date ?
                            $invoice_customer_product_discount->customer_product_discount->start_date->toImmutable() :
                            $product_billing_start_date;

                            $end_date = $invoice_customer_product_discount->customer_product_discount->end_date ?
                            $invoice_customer_product_discount->customer_product_discount->end_date->toImmutable() :
                            $product_billing_end_date;

                            if (! $invoice->billing_date->between($start_date, $end_date)) {
                                $log->new()->properties($invoice_customer_product_discount)->save('discount deleted');
                                $invoice_customer_product_discount->delete();

                                continue;
                            }

                            $hut_ri_76_discount = true;
                        }
                    }
                }

                if ($product_delete) {
                    $product_price = 0;
                    $product_discount = 0;

                    $product_price_after_discount = 0;
                }

                if ($invoice_customer_product->customer_product_price_include_tax) {
                    $log->save('include tax');

                    $product_tax = $product_price_after_discount * $tax_rate / (100 + $tax_rate);
                    $product_tax_base = $product_price_after_discount - $product_tax;
                    $product_total = $product_price_after_discount;
                } else {
                    $log->save('exclude tax');

                    $product_tax = $product_price_after_discount * $tax_rate / 100;
                    $product_tax_base = $product_price_after_discount;
                    $product_total = $product_price_after_discount + $product_tax;
                }

                if ($hut_ri_76_discount && $product_discount === 0) {
                    $product_total = $product_total * 24 / 100;
                    $product_tax_base = $product_total * 100 / (100 + $tax_rate);
                    $product_tax = $product_total * $tax_rate / (100 + $tax_rate);
                    $product_discount = $product_price - $product_tax_base;
                }

                $invoice_customer_product->update([
                    'price' => $product_price,
                    'discount' => $product_discount,
                    'tax' => $product_tax,
                    'tax_base' => $product_tax_base,
                    'total' => $product_total,
                ]);

                $price += $product_price;
                $discount += $product_discount;
                $tax += $product_tax;
                $tax_base += $product_tax_base;
                $total += $product_total;

                if (! $product_delete || ($product_delete && $invoice_customer_product->invoice_customer_product_additionals->count() > 0)) {
                    // additional
                    foreach ($invoice_customer_product->invoice_customer_product_additionals as $invoice_customer_product_additional) {
                        $log->save('looping additional');

                        $additional_billing_start_date = $billing_start_date;
                        $additional_billing_end_date = $billing_end_date;

                        $additional_price = $invoice_customer_product_additional->customer_product_additional_price;
                        $additional_discount = 0;

                        $additional_price_after_discount = 0;

                        // adjust quantity
                        if (
                            $invoice_customer_product_additional->customer_product_additional->adjusted_quantity &&
                            $invoice_customer_product_additional->customer_product_additional->product_additional->quantity_can_be_adjusted
                        ) {
                            $log->save('quantity adjusted');
                            $additional_price = $additional_price * $invoice_customer_product_additional->customer_product_additional->quantity;
                        }

                        // adjust price
                        if (
                            $invoice_customer_product_additional->customer_product_additional->adjusted_price &&
                            $invoice_customer_product_additional->customer_product_additional->product_additional->price_can_be_adjusted
                        ) {
                            $log->save('price adjusted');
                            $additional_price = $invoice_customer_product_additional->customer_product_additional->special_price;
                        }

                        if ($invoice_customer_product_additional->customer_product_additional_payment_scheme_name === 'One Pay') {
                            $log->save('one pay');
                            $additional_date = $invoice_customer_product_additional->customer_product_additional->billing_date ?
                                $invoice_customer_product_additional->customer_product_additional->billing_date->toImmutable() :
                                $additional_billing_start_date;

                            $invoice_customer_product_additional->update([
                                'billing_date' => $additional_date->toDateString(),
                            ]);

                            if (! $additional_date->between($additional_billing_start_date, $additional_billing_end_date)) {
                                $log->new()->properties($invoice_customer_product_additional)->save('deleted, not in billing period');
                                $invoice_customer_product_additional->delete();

                                continue;
                            }
                        } elseif ($invoice_customer_product_additional->customer_product_additional_payment_scheme_name === 'Monthly') {
                            $log->save('monthly');

                            $additional_start_date = $invoice_customer_product_additional->customer_product_additional->billing_start_date ?
                                $invoice_customer_product_additional->customer_product_additional->billing_start_date->toImmutable() :
                                $additional_billing_start_date;

                            $additional_end_date = $invoice_customer_product_additional->customer_product_additional->billing_end_date ?
                                $invoice_customer_product_additional->customer_product_additional->billing_end_date->toImmutable() :
                                $additional_billing_end_date;

                            if ($additional_end_date->lt($additional_billing_start_date)) {
                                $log->new()->properties($invoice_customer_product_additional)->save('deleted, end date less than billing start date');
                                $invoice_customer_product_additional->delete();

                                continue;
                            }

                            if ($additional_start_date->gt($additional_billing_end_date)) {
                                $log->new()->properties($invoice_customer_product_additional)->save('deleted, start date greater than billing end date');
                                $invoice_customer_product_additional->delete();

                                continue;
                            }

                            if ($additional_end_date->lt($additional_start_date)) { // dinonaktifkan sebelum dipakai
                                $log->new()->properties($invoice_customer_product_additional)->save('deleted, end date less than start date');
                                $invoice_customer_product_additional->delete();

                                continue;
                            }

                            $additional_full_billing_period = Period::make($additional_billing_start_date, $additional_billing_end_date);
                            $additional_period = Period::make($additional_start_date, $additional_end_date);
                            $additional_billing_period = $additional_full_billing_period->overlapAll($additional_period);

                            $additional_price = $additional_price * $additional_billing_period->length() / $additional_full_billing_period->length();

                            $invoice_customer_product_additional->update([
                                'billing_start_date' => $additional_billing_period->getStart()->format('Y-m-d'),
                                'billing_end_date' => $additional_billing_period->getEnd()->format('Y-m-d'),
                            ]);
                        }

                        $additional_price_after_discount = $additional_price - $additional_discount;

                        if ($invoice_customer_product_additional->customer_product_additional_price_include_tax) {
                            $log->save('include tax');

                            $additional_tax = $additional_price_after_discount * $tax_rate / (100 + $tax_rate);
                            $additional_tax_base = $additional_price_after_discount - $additional_tax;
                            $additional_total = $additional_price_after_discount;
                        } else {
                            $log->save('exclude tax');

                            $additional_tax = $additional_price_after_discount * $tax_rate / 100;
                            $additional_tax_base = $additional_price_after_discount;
                            $additional_total = $additional_price_after_discount + $additional_tax;
                        }

                        $invoice_customer_product_additional->update([
                            'price' => $additional_price,
                            'discount' => $additional_discount,
                            'tax' => $additional_tax,
                            'tax_base' => $additional_tax_base,
                            'total' => $additional_total,
                        ]);

                        $price += $additional_price;
                        $discount += $additional_discount;
                        $tax += $additional_tax;
                        $tax_base += $additional_tax_base;
                        $total += $additional_total;

                        $product_delete = false;
                    }
                }

                if ($product_delete) {
                    $log->new()->properties($invoice_customer_product)->save('delete');
                    $invoice_customer_product->delete();
                } else {
                    $delete = false;
                }
            }

            // additional
            foreach ($invoice_customer->invoice_customer_product_additionals as $invoice_customer_product_additional) {
                $log->save('looping additional');

                if (
                    $invoice_customer_product_additional->customer_product_additional_name === 'Installation' &&
                    $invoice->hybrid
                ) {
                    $invoice_customer_product_additional->customer_product_additional_name = 'Installation and Activation';
                    $invoice_customer_product_additional->save();
                }

                $additional_billing_start_date = $billing_start_date;
                $additional_billing_end_date = $billing_end_date;

                $additional_price = $invoice_customer_product_additional->customer_product_additional_price;
                $additional_discount = 0;

                $additional_price_after_discount = 0;

                // adjust quantity

                // adjust price
                if (
                    $invoice_customer_product_additional->customer_product_additional->adjusted_price &&
                    $invoice_customer_product_additional->customer_product_additional->product_additional->price_can_be_adjusted
                ) {
                    $log->save('price adjusted');
                    $additional_price = $invoice_customer_product_additional->customer_product_additional->special_price;
                }

                if ($invoice_customer_product_additional->customer_product_additional_payment_scheme_name === 'One Pay') {
                    $log->save('one pay');
                    $additional_date = $invoice_customer_product_additional->customer_product_additional->billing_date ?
                        $invoice_customer_product_additional->customer_product_additional->billing_date->toImmutable() :
                        $additional_billing_start_date;

                    $invoice_customer_product_additional->update([
                        'billing_date' => $additional_date->toDateString(),
                    ]);

                    if (! $additional_date->between($additional_billing_start_date, $additional_billing_end_date)) {
                        $log->new()->properties($invoice_customer_product_additional)->save('deleted, not in billing period');
                        $invoice_customer_product_additional->delete();

                        continue;
                    }
                } elseif ($invoice_customer_product_additional->customer_product_additional_payment_scheme_name === 'Monthly') {
                    $log->save('monthly');

                    $additional_start_date = $invoice_customer_product_additional->customer_product_additional->billing_start_date ?
                        $invoice_customer_product_additional->customer_product_additional->billing_start_date->toImmutable() :
                        $additional_billing_start_date;

                    $additional_end_date = $invoice_customer_product_additional->customer_product_additional->billing_end_date ?
                        $invoice_customer_product_additional->customer_product_additional->billing_end_date->toImmutable() :
                        $additional_billing_end_date;

                    if ($additional_end_date->lt($additional_billing_start_date)) {
                        $log->new()->properties($invoice_customer_product_additional)->save('deleted, end date less than billing start date');
                        $invoice_customer_product_additional->delete();

                        continue;
                    }

                    if ($additional_start_date->gt($additional_billing_end_date)) {
                        $log->new()->properties($invoice_customer_product_additional)->save('deleted, start date greater than billing end date');
                        $invoice_customer_product_additional->delete();

                        continue;
                    }

                    if ($additional_end_date->lt($additional_start_date)) { // dinonaktifkan sebelum dipakai
                        $log->new()->properties($invoice_customer_product_additional)->save('deleted, end date less than start date');
                        $invoice_customer_product_additional->delete();

                        continue;
                    }

                    $additional_full_billing_period = Period::make($additional_billing_start_date, $additional_billing_end_date);
                    $additional_period = Period::make($additional_start_date, $additional_end_date);
                    $additional_billing_period = $additional_full_billing_period->overlapAll($additional_period);

                    $additional_price = $additional_price * $additional_billing_period->length() / $additional_full_billing_period->length();

                    $invoice_customer_product_additional->update([
                        'billing_start_date' => $additional_billing_period->getStart()->format('Y-m-d'),
                        'billing_end_date' => $additional_billing_period->getEnd()->format('Y-m-d'),
                    ]);
                }

                $additional_price_after_discount = $additional_price - $additional_discount;

                if ($invoice_customer_product_additional->customer_product_additional_price_include_tax) {
                    $log->save('include tax');

                    $additional_tax = $additional_price_after_discount * $tax_rate / (100 + $tax_rate);
                    $additional_tax_base = $additional_price_after_discount - $additional_tax;
                    $additional_total = $additional_price_after_discount;
                } else {
                    $log->save('exclude tax');

                    $additional_tax = $additional_price_after_discount * $tax_rate / 100;
                    $additional_tax_base = $additional_price_after_discount;
                    $additional_total = $additional_price_after_discount + $additional_tax;
                }

                $hut_ri_76_discount = false;
                $invoice_customer->customer->customer_products->each(function ($customer_product) use (&$hut_ri_76_discount) {
                    $customer_product->customer_product_discounts->each(function ($customer_product_discount) use (&$hut_ri_76_discount) {
                        if ($customer_product_discount->product_discount->discount->name === 'HUT RI 76') {
                            $hut_ri_76_discount = true;
                        }
                    });
                });

                if ($hut_ri_76_discount && $additional_discount === 0 && $installation) {
                    $additional_total = $additional_total * 24 / 100;
                    $additional_tax_base = $additional_total * 100 / (100 + $tax_rate);
                    $additional_tax = $additional_total * $tax_rate / (100 + $tax_rate);
                    $additional_discount = $additional_price - $additional_tax_base;
                }

                $invoice_customer_product_additional->update([
                    'price' => $additional_price,
                    'discount' => $additional_discount,
                    'tax' => $additional_tax,
                    'tax_base' => $additional_tax_base,
                    'total' => $additional_total,
                ]);

                $price += $additional_price;
                $discount += $additional_discount;
                $tax += $additional_tax;
                $tax_base += $additional_tax_base;
                $total += $additional_total;

                $delete = false;
            }
        }

        if ($invoice->ignore_tax) {
            $total = $total - $tax;
            $tax = 0;
            $tax_base = 0;
        }

        $invoice->update([
            'price' => $price,
            'discount' => $discount,
            'tax' => $tax,
            'tax_base' => $tax_base,
            'total' => $total,
        ]);

        // ganti dengan exception!
        if (intval($total) === 0) {
            $log->save('delete, total is 0');
            $delete = true;
        }

        if ($delete) {
            $log->new()->properties($invoice)->save('invoice deleted');
            $invoice->delete();
        } else {
            // previous remaining payment
            $previous_remaining_payment = 0; // sisa pembayaran sebelumnya
            $remaining_payment = 0; // sisa pembayaran

            $scheme->load('invoices');
            $scheme->invoices->each(function ($invoice) use (&$previous_remaining_payment, &$remaining_payment) {
                $previous_remaining_payment += $invoice->previous_remaining_payment;
                $remaining_payment += $invoice->remaining_payment;
            });

            $previous_remaining_payment = $remaining_payment - $previous_remaining_payment;
            $total -= $previous_remaining_payment;

            $log->new()->properties($invoice)->save('invoice before updated');
            $invoice->update([
                'previous_remaining_payment' => $previous_remaining_payment,
                'total' => $total,
            ]);

            $invoice->refresh();

            TaxOut::create($invoice);
            Customer::updateInstallationInvoiceDueDate($invoice);

            $temporary_disk = config('filesystems.temporary_disk');

            if ($invoice->brand_type_name === 'Retail Internet Service') {
                dispatch(new ArInvoiceCreatePdfRetailInternet($invoice->id));
                if ($temporary_disk) {
                    dispatch(new ArInvoiceCreatePdfRetailInternet($invoice->id, $temporary_disk));
                }
            } else {
                dispatch(new ArInvoiceCreatePdf($invoice->id));
                if ($temporary_disk) {
                    dispatch(new ArInvoiceCreatePdf($invoice->id, $temporary_disk));
                }
            }

            dispatch(new ArInvoiceCreatePdfReceipt($invoice->id));
            if ($temporary_disk) {
                dispatch(new ArInvoiceCreatePdfReceipt($invoice->id, $temporary_disk));
            }
        }
    }

    public static function createOrUpdateEarliest(ArInvoiceSchemeModel $scheme, $created_by_cron = false)
    {
        $log = applog('erp, ar_invoice__fac, create_or_update_earliest');
        $log->save('debug');

        $scheme->load([
            'scheme_customers',
            'scheme_customers.scheme_customer_products',
            'scheme_customers.scheme_customer_products.customer_product',
            'scheme_customers.scheme_customer_products.customer_product.product',
            'scheme_customers.scheme_customer_products.customer_product.product.payment_scheme',

            'scheme_customers.scheme_customer_products.customer_product.customer_product_additionals',
            'scheme_customers.scheme_customer_products.customer_product.customer_product_additionals.product_additional',
            'scheme_customers.scheme_customer_products.customer_product.customer_product_additionals.product_additional.payment_scheme',

            'scheme_customers.scheme_customer_products.customer_product.customer_product_discounts',
            'scheme_customers.scheme_customer_products.customer_product.customer_product_discounts.product_discount',
            'scheme_customers.scheme_customer_products.customer_product.customer_product_discounts.product_discount.discount',
        ]);

        $billing_date = null;

        $scheme->scheme_customers->each(function ($scheme_customer) use (&$billing_date) {
            $scheme_customer->scheme_customer_products->each(function ($scheme_customer_product) use (&$billing_date) {
                $customer_product = $scheme_customer_product->customer_product;

                if ($customer_product->product) {
                    if ($customer_product->product->payment_scheme->name === 'One Pay') {
                        if ($customer_product->billing_date) {
                            if (
                                ! $billing_date or
                                $customer_product->billing_date->lt($billing_date)
                            ) {
                                $billing_date = $customer_product->billing_date;
                            }
                        }
                    } elseif ($customer_product->product->payment_scheme->name === 'Monthly') {
                        if ($customer_product->billing_start_date) {
                            if (
                                ! $billing_date or
                                $customer_product->billing_start_date->lt($billing_date)
                            ) {
                                $billing_date = $customer_product->billing_start_date;
                            }
                        }
                    }
                }

                $customer_product->customer_product_additionals->each(function ($customer_product_additional) use (&$billing_date) {
                    if (! $customer_product_additional->product_additional) {
                        return true;
                    }
                    if ($customer_product_additional->product_additional->name === 'Installation') {
                        return true;
                    }

                    if ($customer_product_additional->product_additional->payment_scheme->name === 'One Pay') {
                        if ($customer_product_additional->billing_date) {
                            if (
                                ! $billing_date or
                                $customer_product_additional->billing_date->lt($billing_date)
                            ) {
                                $billing_date = $customer_product_additional->billing_date;
                            }
                        }
                    } elseif ($customer_product_additional->product_additional->payment_scheme->name === 'Monthly') {
                        if ($customer_product_additional->billing_start_date) {
                            if (
                                ! $billing_date or
                                $customer_product_additional->billing_start_date->lt($billing_date)
                            ) {
                                $billing_date = $customer_product_additional->billing_start_date;
                            }
                        }
                    }
                });

                if ($billing_date) {
                    Customer::correctingDiscount($customer_product, $billing_date);
                }
            });
        });

        if ($billing_date) {
            $billing_date = $billing_date->toImmutable();
            $first_billing_date = $billing_date;

            while ($billing_date->lte(Carbon::now()->endOfMonth()->endOfDay())) {
                $log->save('create earliest invoice');

                if (
                    ! $scheme->ignore_prorated && // prorated
                    ! $billing_date->isSameMonth($first_billing_date) // invoice prorated pertama tanggalnya sesuai inputan
                ) {
                    $invoice_date = $billing_date->startOfMonth()->toImmutable();
                    $invoice_billing_date = $billing_date->startOfMonth()->toImmutable();
                } else {
                    $invoice_date = $billing_date->toImmutable();
                    $invoice_billing_date = $billing_date->toImmutable();
                }

                $invoice_uuid = null;
                $invoice_number = null;

                $invoice_query = $scheme->invoices()
                    ->where('date', $invoice_date)
                    ->where('billing_date', $invoice_billing_date);

                $invoice = $invoice_query->first();

                if ($invoice) {
                    if (! $invoice->paid && ! $invoice->email_sent && ! $invoice->whatsapp_sent) {
                        $invoice_uuid = $invoice->uuid;
                        $invoice_number = $invoice->number;

                        $invoice->delete();
                        static::create($scheme, $invoice_date, $invoice_billing_date, $created_by_cron, $invoice_number, $invoice_uuid);
                    } else {
                        static::updateBillingEndDateIndex($invoice);
                    }
                } else {
                    static::create($scheme, $invoice_date, $invoice_billing_date, $created_by_cron);
                }

                $billing_date = $billing_date->addMonthNoOverflow();
            }
        }
    }

    public static function createOrUpdateInstallation(ArInvoiceSchemeModel $scheme)
    {
        $log = applog('erp, ar_invoice__fac, create_or_update_installation');
        $log->save('debug');

        $scheme->load([
            'scheme_customers',
            'scheme_customers.scheme_customer_product_additionals',
            'scheme_customers.scheme_customer_product_additionals.customer_product_additional',
            'scheme_customers.scheme_customer_product_additionals.customer_product_additional.product_additional',
        ]);

        $billing_date = null;

        $scheme->scheme_customers->each(function ($scheme_customer) use (&$billing_date) {
            $scheme_customer->scheme_customer_product_additionals->each(function ($scheme_customer_product_additional) use (&$billing_date) {
                $customer_product_additional = $scheme_customer_product_additional->customer_product_additional;

                if ($customer_product_additional->product_additional && $customer_product_additional->product_additional->name === 'Installation') {
                    if ($customer_product_additional->billing_date) {
                        if (
                            ! $billing_date or
                            $customer_product_additional->billing_date->lt($billing_date)
                        ) {
                            $billing_date = $customer_product_additional->billing_date;
                        }
                    }
                }
            });
        });

        if ($billing_date) {
            $invoice_uuid = null;
            $invoice_number = null;

            $invoice_query = $scheme->invoices();
            $invoice = $invoice_query->first();

            if ($invoice) {
                if (! $invoice->paid && ! $invoice->email_sent && ! $invoice->whatsapp_sent) {
                    $invoice_uuid = $invoice->uuid;
                    $invoice_number = $invoice->number;

                    $invoice->delete();
                    static::create($scheme, $billing_date, $billing_date, false, $invoice_number, $invoice_uuid);
                } else {
                    static::updateBillingEndDateIndex($invoice);
                }
            } else {
                static::create($scheme, $billing_date, $billing_date);
            }
        }
    }

    public static function createOrUpdate(ArInvoiceSchemeModel $scheme, $created_by_cron = false)
    {
        $log = applog('erp, ar_invoice__fac, create_or_update');
        $log->save('debug');

        if (Str::contains($scheme->name, 'Installation')) {
            static::createOrUpdateInstallation($scheme);
        } else {
            static::createOrUpdateEarliest($scheme, $created_by_cron);
        }
    }

    public static function delete(ArInvoiceSchemeModel $scheme)
    {
        $log = applog('erp, ar_invoice__fac, delete');
        $log->save('debug');

        DB::table('ar_invoice')->where([
            'ar_invoice_scheme_id' => $scheme->id,
            'paid' => false,
            'email_sent' => false,
            'whatsapp_sent' => false,
        ])->delete();
    }

    public static function createAdditionalInvoice(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, ar_invoice__fac, create_additional_invoice');
        $log->save('debug');

        $schemes = ArInvoiceScheme::getAdditionalSchemes($customer_product_additional);

        $schemes->each(function ($scheme) {
            if (Str::contains($scheme->name, 'Installation')) {
                static::createOrUpdateInstallation($scheme);
            } else {
                static::createOrUpdateEarliest($scheme);
            }
        });
    }

    public static function updateAdditionalInvoice(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, ar_invoice__fac, update_additional_invoice');
        $log->save('debug');

        static::createAdditionalInvoice($customer_product_additional);
    }

    public static function deleteAdditionalInvoice(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, ar_invoice__fac, delete_additional_invoice');
        $log->save('debug');

        $schemes = ArInvoiceScheme::getAdditionalSchemes($customer_product_additional);

        $schemes->each(function ($scheme) {
            static::delete($scheme);
        });
    }

    public static function createProductInvoice(CustomerProduct $customer_product)
    {
        $log = applog('erp, ar_invoice__fac, create_product_invoice');
        $log->save('debug');

        $schemes = ArInvoiceScheme::getProductSchemes($customer_product);

        $schemes->each(function ($scheme) {
            if (Str::contains($scheme->name, 'Installation')) {
                static::createOrUpdateInstallation($scheme);
            } else {
                static::createOrUpdateEarliest($scheme);
            }
        });
    }

    public static function updateProductInvoice(CustomerProduct $customer_product)
    {
        $log = applog('erp, ar_invoice__fac, update_product_invoice');
        $log->save('debug');

        static::createProductInvoice($customer_product);
    }

    public static function deleteProductInvoice(CustomerProduct $customer_product)
    {
        $log = applog('erp, ar_invoice__fac, delete_product_invoice');
        $log->save('debug');

        $schemes = ArInvoiceScheme::getProductSchemes($customer_product);

        $schemes->each(function ($scheme) {
            static::delete($scheme);
        });
    }

    public static function createCustomerInvoice(CustomerModel $customer)
    {
        $log = applog('erp, ar_invoice__fac, create_customer_invoice');
        $log->save('debug');

        $schemes = ArInvoiceScheme::getCustomerSchemes($customer);

        $schemes->each(function ($scheme) {
            if (Str::contains($scheme->name, 'Installation')) {
                static::createOrUpdateInstallation($scheme);
            } else {
                static::createOrUpdateEarliest($scheme);
            }
        });
    }

    public static function updateCustomerInvoice(CustomerModel $customer)
    {
        $log = applog('erp, ar_invoice__fac, update_customer_invoice');
        $log->save('debug');

        static::createCustomerInvoice($customer);
    }

    public static function deleteCustomerInvoice(CustomerModel $customer)
    {
        $log = applog('erp, ar_invoice__fac, delete_customer_invoice');
        $log->save('debug');

        $schemes = ArInvoiceScheme::getCustomerSchemes($customer);

        $schemes->each(function ($scheme) {
            static::delete($scheme);
        });
    }

    public static function midtransGetStatus($order_id)
    {
        $log = applog('erp, ar_invoice__fac, update_payment_status');
        $log->save('debug');

        $log->new()->properties($order_id)->save('order id');
        $invoice_midtrans = ArInvoiceMidtrans::where('order_id', $order_id)->first();
        $invoice = $invoice_midtrans->invoice;

        if (! $invoice) {
            return;
        }
        if ($invoice->paid) {
            return;
        }

        $url = FacadesApp::environment('production') ?
            'https://api.midtrans.com/v2/'.$order_id.'/status' :
            'https://api.sandbox.midtrans.com/v2/'.$order_id.'/status';

        $request = new GuzzleRequest('GET', $url, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode(config('app.midtrans_server_key').':'),
        ]);
        $response = (new GuzzleClient())->sendRequest($request);

        if ($response->getStatusCode() === 400) {
            $log->save('Missing or invalid data.');
        } elseif ($response->getStatusCode() === 401) {
            $log->save('Authentication error.');
        } elseif ($response->getStatusCode() === 404) {
            $log->save('The requested resource is not found.');
        }

        $response_body = json_decode($response->getBody()->getContents());
        $log->new()->properties($response_body)->save('response body');

        $transaction_status = $response_body->transaction_status;
        $fraud_status = $response_body->fraud_status;
        $payment_type = $response_body->payment_type;

        static::midtransHandle($invoice->uuid, $transaction_status, $fraud_status, $payment_type);
    }

    public static function midtransHandle($order_id, $transaction_status, $fraud_status, $payment_type)
    {
        $log = applog('erp, ar_invoice__fac, midtrans_handle');
        $log->save('debug');

        $log->new()->properties(['order_id' => $order_id])->save('midtrans handle');

        $invoice_midtrans = ArInvoiceMidtrans::where('order_id', $order_id)->get();
        if (! $invoice_midtrans) {
            return 'not found';
        }

        $success = false;
        $expire = false;
        $message = 'unpaid';

        foreach ($invoice_midtrans as $invoice_midtrans_item) {
            $invoice = $invoice_midtrans_item->invoice;
            if (! $invoice) {
                return 'invoice not found';
            }

            if ($transaction_status === 'capture') {
                $log->save('capture');
                $message = 'capture';

                if ($payment_type === 'credit_card') {
                    $log->save('credit card');
                    if ($fraud_status === 'challenge') {
                        $log->save('challenge');
                        $message = 'challenge';
                    } else {
                        $log->save('success');
                        $success = true;
                    }
                }
            } elseif ($transaction_status === 'settlement') {
                $log->save('settlement');
                $log->save('success');
                $success = true;
            } elseif ($transaction_status === 'pending') {
                $log->save('pending');
                $message = 'pending';

                dispatch(new MidtransGetStatus($order_id, $invoice->id, $log))->delay(now()->addMinutes(60));
            } elseif ($transaction_status === 'deny') {
                $log->save('deny');
                $message = 'deny';
            } elseif ($transaction_status === 'expire') {
                $log->save('expire');
                $message = 'expire';
                $expire = true;
            } elseif ($transaction_status === 'cancel') {
                $log->save('cancel');
                $message = 'cancel';
            }

            if ($success) {
                $message = 'success';

                $log->new()->properties($invoice)->save('invoice data');
                $log->new()->properties($invoice_midtrans_item)->save('invoice midtrans data');

                $invoice->paid = true;
                $invoice->paid_at = Carbon::now()->toDateTimeString();
                $invoice->paid_submit_at = Carbon::now()->toDateTimeString();
                $invoice->payment_date = Carbon::now()->toDateString();
                $invoice->paid_via_midtrans = true;
                $invoice->paid_total = $invoice->total;
                $invoice->save();

                $invoice_midtrans_item->payment_type = $payment_type;
                $invoice_midtrans_item->transaction_status = $transaction_status;
                $invoice_midtrans_item->fraud_status = $fraud_status;
                $invoice_midtrans_item->save();
                static::midtransUpdatePaymentCost($invoice_midtrans_item);

                $invoice->refresh();

                // update pdf
                $temporary_disk = config('filesystems.temporary_disk');

                if ($invoice->brand_type_name === 'Retail Internet Service') {
                    dispatch(new ArInvoiceCreatePdfRetailInternet($invoice->id));
                    if ($temporary_disk) {
                        dispatch(new ArInvoiceCreatePdfRetailInternet($invoice->id, $temporary_disk));
                    }
                } else {
                    dispatch(new ArInvoiceCreatePdf($invoice->id));
                    if ($temporary_disk) {
                        dispatch(new ArInvoiceCreatePdf($invoice->id, $temporary_disk));
                    }
                }

                dispatch(new ArInvoiceCreateAndSendPdfReceiptWhatsapp($invoice->id));
                if ($temporary_disk) {
                    dispatch(new ArInvoiceCreateAndSendPdfReceiptWhatsapp($invoice->id, $temporary_disk));
                }

                Service::updateIsolation($invoice);
                Customer::updateInstallationInvoicePaidDate($invoice);
                Customer::updatePaymentActiveStatusByInvoice($invoice);
                // log
                $invoice_log = ArInvoiceLog::create([
                    'title' => 'paid',
                    'ar_invoice_id' => $invoice->id,
                ]);
                dd($invoice_log);
                $log->new()->properties($invoice_log->id)->save('ar invoice log');
            }

            if ($expire) {
                $message = 'expire';

                $log->new()->properties($invoice)->save('invoice data expire');
                $log->new()->properties($invoice_midtrans_item)->save('invoice midtrans data expire');

                $invoice_midtrans_item->payment_type = $payment_type;
                $invoice_midtrans_item->transaction_status = $transaction_status;
                $invoice_midtrans_item->save();

                // log
                $invoice_log = ArInvoiceLog::create([
                    'title' => 'expire',
                    'ar_invoice_id' => $invoice->id,
                ]);
                $log->new()->properties($invoice_log->id)->save('ar invoice expire log');
            }
        }

        return $message;
    }

    public static function midtransUpdatePaymentCost(ArInvoiceMidtrans $invoice_midtrans)
    {
        $log = applog('erp, ar_invoice__fac, midtrans_update_payment_cost');
        $log->save('debug');

        $invoice = $invoice_midtrans->invoice;

        if (! $invoice->midtrans_payment_cost) {
            $invoice->midtrans_payment_cost = 0;
        }
        $success = false;

        if ($invoice_midtrans->transaction_status === 'capture') {
            if ($invoice_midtrans->payment_type === 'credit_card') {
                if ($invoice_midtrans->fraud_status === 'challenge') {
                    // challenge
                } else {
                    $success = true;
                }
            }
        } elseif ($invoice_midtrans->transaction_status === 'settlement') {
            $success = true;
        } elseif ($invoice_midtrans->transaction_status === 'pending') {
            // pending
        } elseif ($invoice_midtrans->transaction_status === 'deny') {
            // deny
        } elseif ($invoice_midtrans->transaction_status === 'expire') {
            // expire
        } elseif ($invoice_midtrans->transaction_status === 'cancel') {
            // cancel
        }

        if ($success) {
            $invoice->midtrans_payment_type = $invoice_midtrans->payment_type;

            switch ($invoice_midtrans->payment_type) { // https://midtrans.com/id/pricing
                case 'akulaku':
                    $invoice->midtrans_payment_cost = $invoice->total * 0.017;
                    break;

                case 'alfamart':
                    $invoice->midtrans_payment_cost = 5000;
                    break;

                case 'bank_transfer':
                    $invoice->midtrans_payment_cost = 4000;
                    break;

                case 'bca':
                    $invoice->midtrans_payment_cost = 4000;
                    break;

                case 'bni':
                    $invoice->midtrans_payment_cost = 4000;
                    break;

                case 'credit_card':
                    $invoice->midtrans_payment_cost = ($invoice->total * 0.029) + 2000;
                    break;

                case 'cstore':
                    $invoice->midtrans_payment_cost = 5000; // over the counter cost
                    break;

                case 'echannel':
                    $invoice->midtrans_payment_cost = 4000; // bank transfer cost
                    break;

                case 'gojek':
                    $invoice->midtrans_payment_cost = $invoice->total * 0.02;
                    break;

                case 'gopay':
                    $invoice->midtrans_payment_cost = $invoice->total * 0.02;
                    break;

                case 'mandiri':
                    $invoice->midtrans_payment_cost = 4000;
                    break;

                case 'qris':
                    $invoice->midtrans_payment_cost = $invoice->total * 0.007;
                    break;

                case 'shopeepay':
                    $invoice->midtrans_payment_cost = $invoice->total * 0.015;
                    break;

                default:
                    $invoice->midtrans_payment_cost = 0;
                    break;
            }
        }

        $invoice->save();
    }

    public static function midtransUpdatePaymentCosts(ArInvoiceModel $invoice)
    {
        $log = applog('erp, ar_invoice__fac, midtrans_update_payment_costs');
        $log->save('debug');

        $invoice->midtrans->each(function ($payment) {
            static::midtransUpdatePaymentCost($payment);
        });
    }

    public static function midtransUpdatePaymentCostUuid($uuid)
    {
        $log = applog('erp, ar_invoice__fac, midtrans_update_payment_cost_uuid');
        $log->save('debug');

        $invoice = ArInvoiceModel::where('uuid', $uuid)->first();
        if ($invoice) {
            static::midtransUpdatePaymentCosts($invoice);
        }
    }

    public static function createPdf(ArInvoiceModel $invoice, $disk = null)
    {
        $log = applog('erp, ar_invoice__fac, create_pdf');
        $log->save('debug');

        // collecting
        $invoice->load([
            'invoice_customers:id,ar_invoice_id',
            'invoice_customers.invoice_customer_products' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_product_id',
                ]);
            },
            'invoice_customers.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
        ]);

        $invoice = $invoice->toArray();

        // mapping
        $invoice['company_name'] = $invoice['receiver_name'];
        $invoice['company_address'] = $invoice['receiver_address'];
        $invoice['company_postal_code'] = $invoice['receiver_postal_code'];
        $invoice['company_phone_number'] = $invoice['receiver_phone_number'];
        $invoice['company_fax'] = $invoice['receiver_fax'];
        $invoice['company_email'] = $invoice['receiver_email'];

        $invoice['customer_name'] = $invoice['payer_name'];
        $invoice['customer_address'] = $invoice['payer_address'];
        $invoice['customer_postal_code'] = $invoice['payer_postal_code'];
        $invoice['customer_phone_number'] = $invoice['payer_phone_number'];
        $invoice['customer_email'] = $invoice['payer_email'];
        $invoice['customer_cid'] = $invoice['payer_cid'];

        if (! $invoice['company_fax']) {
            $invoice['company_fax'] = '-';
        }
        if (! $invoice['customer_phone_number']) {
            $invoice['customer_phone_number'] = '-';
        }
        if (! $invoice['customer_email']) {
            $invoice['customer_email'] = '-';
        }

        $invoice['billing_start_date'] = '-';
        $invoice['billing_end_date'] = '-';

        $invoice['customers'] = collect($invoice['invoice_customers'])->map(function ($customer) use (&$invoice) {
            $customer['products'] = collect($customer['invoice_customer_products'])->map(function ($product) use (&$invoice) {
                $product['additionals'] = collect($product['invoice_customer_product_additionals'])->map(function ($additional) {
                    $additional['price'] = number_format($additional['price'], 0, ',', '.');

                    return $additional;
                })->all();
                unset($product['invoice_customer_product_additionals']);

                if ($product['customer_product_payment_scheme_name'] === 'Monthly') {
                    if ($product['billing_start_date']) {
                        $start_date = Carbon::createFromFormat('Y-m-d', $product['billing_start_date']);
                        $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    }

                    if ($product['billing_end_date']) {
                        $end_date = Carbon::createFromFormat('Y-m-d', $product['billing_end_date']);
                        $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');
                    }
                }

                $product['price'] = number_format($product['price'], 0, ',', '.');

                return $product;
            })->all();
            unset($customer['invoice_customer_products']);

            $customer['additionals'] = collect($customer['invoice_customer_product_additionals'])->map(function ($additional) use (&$invoice) {
                if ($additional['customer_product_additional_payment_scheme_name'] === 'Monthly') {
                    if ($additional['billing_start_date']) {
                        $start_date = Carbon::createFromFormat('Y-m-d', $additional['billing_start_date']);
                        $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    }

                    if ($additional['billing_end_date']) {
                        $end_date = Carbon::createFromFormat('Y-m-d', $additional['billing_end_date']);
                        $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');
                    }
                }

                $additional['price'] = number_format($additional['price'], 0, ',', '.');

                return $additional;
            })->all();
            unset($customer['invoice_customer_product_additionals']);

            return $customer;
        })->all();
        unset($invoice['invoice_customers']);

        $invoice['date'] = Carbon::createFromFormat('Y-m-d', $invoice['date'])->translatedFormat('d F Y');
        $invoice['due_date'] = Carbon::createFromFormat('Y-m-d', $invoice['due_date'])->translatedFormat('d F Y');
        $invoice['billing_date'] = Carbon::createFromFormat('Y-m-d', $invoice['billing_date'])->translatedFormat('d F Y');

        $prevRemainingIsPositive = $invoice['previous_remaining_payment'] >= 0;

        $invoice['discount'] = 'Rp'.number_format($invoice['discount'], 0, ',', '.');
        $invoice['tax_base'] = 'Rp'.number_format($invoice['tax_base'], 0, ',', '.');
        $invoice['tax'] = 'Rp'.number_format($invoice['tax'], 0, ',', '.');
        $invoice['previous_remaining_payment'] = 'Rp'.number_format($invoice['previous_remaining_payment'], 0, ',', '.');
        $invoice['words'] = CalculateFac::process((int) $invoice['total']);
        $invoice['total'] = 'Rp'.number_format($invoice['total'], 0, ',', '.');

        if ($prevRemainingIsPositive) {
            $invoice['previous_remaining_payment'] = '- '.$invoice['previous_remaining_payment'];
        }

        $invoice['qrcode_url'] = (new QRCode)->render($invoice['number']);

        $data['invoice'] = $invoice;

        $pdf = (new PdfWrapper())->loadView('pdf.ar_invoice.doc', $data, [], [
            'format' => 'Legal',
            'title' => 'Invoice',
            'creator' => $invoice['brand_name'],
        ]);

        $file_path = 'invoice/'.str_replace('/', '_', $invoice['number']).'.pdf';

        if (! $disk) {
            $disk = config('filesystems.primary_disk');
        }

        $storage = Storage::disk($disk);
        if ($storage->exists($file_path)) {
            $storage->delete($file_path);
        }
        $storage->put($file_path, $pdf->output(), 'public');
    }

    public static function createPdfRetailInternet(ArInvoiceModel $invoice, $disk = null)
    {
        $log = applog('erp, ar_invoice__fac, create_pdf_retail_internet');
        $log->save('debug');

        // collecting
        $invoice->load([
            'invoice_customers:id,ar_invoice_id',
            'invoice_customers.invoice_customer_products' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_product_id',
                ]);
            },
            'invoice_customers.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
        ]);

        $invoice_ref = $invoice;
        $invoice = $invoice->toArray();

        // mapping
        $invoice['customer_cid'] = $invoice['payer_cid'];
        $invoice['customer_name'] = $invoice['payer_name'];
        $invoice['customer_address'] = $invoice['payer_address'];
        $invoice['customer_phone_number'] = $invoice['payer_phone_number'];

        if (! $invoice['customer_address']) {
            $invoice['customer_address'] = '-';
        }
        if (! $invoice['customer_phone_number']) {
            $invoice['customer_phone_number'] = '-';
        }

        $invoice['billing_start_date'] = '-';
        $invoice['billing_end_date'] = '-';

        $invoice['customers'] = collect($invoice['invoice_customers'])->map(function ($customer) use (&$invoice) {
            $customer['products'] = collect($customer['invoice_customer_products'])->map(function ($product) use (&$invoice) {
                $product['additionals'] = collect($product['invoice_customer_product_additionals'])->map(function ($additional) {
                    $additional['price'] = 'Rp'.number_format($additional['price'], 0, ',', '.');

                    return $additional;
                })->all();
                unset($product['invoice_customer_product_additionals']);

                if ($product['customer_product_payment_scheme_name'] === 'Monthly') {
                    if ($product['billing_start_date']) {
                        $start_date = Carbon::createFromFormat('Y-m-d', $product['billing_start_date'])->toImmutable();
                        $invoice['billing_start_date'] = $invoice['hybrid'] ?
                            $start_date->addMonthNoOverflow()->translatedFormat('d F Y') :
                            $start_date->translatedFormat('d F Y');
                    }

                    if ($product['billing_end_date']) {
                        $end_date = Carbon::createFromFormat('Y-m-d', $product['billing_end_date'])->toImmutable();
                        $invoice['billing_end_date'] = $invoice['hybrid'] ?
                            $end_date->addMonthNoOverflow()->translatedFormat('d F Y') :
                            $end_date->translatedFormat('d F Y');
                    }
                }

                $product['price'] = 'Rp'.number_format($product['price'], 0, ',', '.');

                return $product;
            })->all();

            unset($customer['invoice_customer_products']);
            $customer['additionals'] = collect($customer['invoice_customer_product_additionals'])->map(function ($additional) use (&$invoice) {
                if ($additional['customer_product_additional_payment_scheme_name'] === 'Monthly') {
                    if ($additional['billing_start_date']) {
                        $start_date = Carbon::createFromFormat('Y-m-d', $additional['billing_start_date']);
                        $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    }

                    if ($additional['billing_end_date']) {
                        $end_date = Carbon::createFromFormat('Y-m-d', $additional['billing_end_date']);
                        $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');
                    }
                }

                $additional['price'] = 'Rp'.number_format($additional['price'], 0, ',', '.');

                return $additional;
            })->all();
            unset($customer['invoice_customer_product_additionals']);

            return $customer;
        })->all();

        unset($invoice['invoice_customers']);

        $invoice['date'] = Carbon::createFromFormat('Y-m-d', $invoice['date'])->translatedFormat('d F Y');
        $invoice['due_date'] = Carbon::createFromFormat('Y-m-d', $invoice['due_date'])->translatedFormat('d F Y');
        $invoice['billing_date'] = Carbon::createFromFormat('Y-m-d', $invoice['billing_date'])->translatedFormat('d F Y');

        $invoice['previous_date'] = $invoice['previous_date'] ? Carbon::createFromFormat('Y-m-d', $invoice['previous_date'])->translatedFormat('d F Y') : '-';
        $invoice['previous_total'] = $invoice['previous_total'] ? 'Rp'.number_format($invoice['previous_total'], 0, ',', '.') : 'Rp0';

        $prevRemainingIsPositive = $invoice['previous_remaining_payment'] >= 0;

        $invoice['discount'] = 'Rp'.number_format($invoice['discount'], 0, ',', '.');
        $invoice['tax_base'] = 'Rp'.number_format($invoice['tax_base'], 0, ',', '.');
        $invoice['tax'] = 'Rp'.number_format($invoice['tax'], 0, ',', '.');
        $invoice['previous_remaining_payment'] = 'Rp'.number_format($invoice['previous_remaining_payment'], 0, ',', '.');
        $invoice['total'] = 'Rp'.number_format($invoice['total'], 0, ',', '.');

        if ($prevRemainingIsPositive) {
            $invoice['previous_remaining_payment'] = '- '.$invoice['previous_remaining_payment'];
        }

        $payment_link = config('app.client_domain') != null ? config('app.client_domain') : 'https://staging.api.erpv2.gmedia.id'.'/pay'.'/'.$invoice_ref->uuid;
        $invoice['qr_code'] = (new PngWriter())->write(EndroidQrCode::create($payment_link)->setSize(144)->setMargin(0))->getDataUri();
        $data['invoice'] = $invoice;

        // $pdf = (new PdfWrapper())->loadView('pdf.ar_invoice.retail_internet_doc', $data, [], [
        //     'format' => 'Legal',
        //     'title' => 'Invoice',
        //     'creator' => $invoice['brand_name'],
        // ]);

        $file_path = 'invoice/'.str_replace('/', '_', $invoice['number']).'.pdf';

        if (! $disk) {
            $disk = config('filesystems.primary_disk');
        }

        $storage = Storage::disk($disk);
        if ($storage->exists($file_path)) {
            $storage->delete($file_path);
        }
        // $storage->put($file_path, $pdf->output(), 'public');
    }

    public static function createReceiptPdf(ArInvoiceModel $invoice, $disk = null)
    {
        $log = applog('erp, ar_invoice__fac, create_receipt_pdf');
        $log->save('debug');

        // collecting
        $invoice->load([
            'invoice_customers:id,ar_invoice_id',
            'invoice_customers.invoice_customer_products' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_name as name',
                    'price',
                    'ar_invoice_customer_id',
                ]);
            },
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'ar_invoice_customer_product_id',
                ]);
            },
            'invoice_customers.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'ar_invoice_customer_id',
                ]);
            },
        ]);

        $invoice = $invoice->toArray();

        // mapping
        $invoice['company_name'] = $invoice['receiver_name'];
        $invoice['company_address'] = $invoice['receiver_address'];
        $invoice['company_postal_code'] = $invoice['receiver_postal_code'];
        $invoice['company_phone_number'] = $invoice['receiver_phone_number'];
        $invoice['company_fax'] = $invoice['receiver_fax'];
        $invoice['company_email'] = $invoice['receiver_email'];

        $invoice['customer_name'] = $invoice['payer_name'];
        $invoice['customer_address'] = $invoice['payer_address'];
        $invoice['customer_postal_code'] = $invoice['payer_postal_code'];
        $invoice['customer_phone_number'] = $invoice['payer_phone_number'];
        $invoice['customer_email'] = $invoice['payer_email'];
        $invoice['customer_cid'] = $invoice['payer_cid'];

        if (! $invoice['company_fax']) {
            $invoice['company_fax'] = '-';
        }
        if (! $invoice['customer_phone_number']) {
            $invoice['customer_phone_number'] = '-';
        }

        $invoice['customers'] = collect($invoice['invoice_customers'])->map(function ($customer) {
            $customer['products'] = collect($customer['invoice_customer_products'])->map(function ($product) {
                $product['additionals'] = collect($product['invoice_customer_product_additionals'])->map(function ($additional) {
                    $additional['price'] = number_format($additional['price'], 0, ',', '.');

                    return $additional;
                })->all();
                unset($product['invoice_customer_product_additionals']);

                $product['price'] = number_format($product['price'], 0, ',', '.');

                return $product;
            })->all();
            unset($customer['invoice_customer_products']);

            $customer['additionals'] = collect($customer['invoice_customer_product_additionals'])->map(function ($additional) {
                $additional['price'] = number_format($additional['price'], 0, ',', '.');

                return $additional;
            })->all();
            unset($customer['invoice_customer_product_additionals']);

            return $customer;
        })->all();
        unset($invoice['invoice_customers']);

        $invoice['date'] = Carbon::createFromFormat('Y-m-d', $invoice['date'])->translatedFormat('d F Y');
        $invoice['due_date'] = Carbon::createFromFormat('Y-m-d', $invoice['due_date'])->translatedFormat('d F Y');

        if ($invoice['paid_at']) {
            $invoice['paid_at'] = Carbon::parse($invoice['paid_at'])->format('Y-m-d H:i:s');
        } else {
            $invoice['paid_at'] = '-';
        }
        $prevRemainingIsPositive = $invoice['previous_remaining_payment'] >= 0;

        $invoice['discount'] = 'Rp'.number_format($invoice['discount'], 0, ',', '.');
        $invoice['tax_base'] = 'Rp'.number_format($invoice['tax_base'], 0, ',', '.');
        $invoice['tax'] = 'Rp'.number_format($invoice['tax'], 0, ',', '.');
        $invoice['previous_remaining_payment'] = 'Rp'.number_format($invoice['previous_remaining_payment'], 0, ',', '.');
        $invoice['total'] = 'Rp'.number_format($invoice['total'], 0, ',', '.');

        if ($prevRemainingIsPositive) {
            $invoice['previous_remaining_payment'] = '- '.$invoice['previous_remaining_payment'];
        }

        $invoice['qrcode_url'] = (new QRCode())->render($invoice['uuid']);

        $data['invoice'] = $invoice;

        // $pdf = (new PdfWrapper())->loadView('pdf.ar_invoice.receipt_doc', $data, [], [
        //     'format' => 'A4',
        //     'margin_header' => 0,
        //     'margin_footer' => 0,
        //     'margin_top' => 10,
        //     'margin_right' => 10,
        //     'margin_bottom' => 10,
        //     'margin_left' => 10,
        //     'title' => 'Receipt',
        //     'creator' => $invoice['brand_name'],
        // ]);

        $file_path = 'invoice_receipt/'.str_replace('/', '_', $invoice['number']).'.pdf';

        if (! $disk) {
            $disk = config('filesystems.primary_disk');
        }

        $storage = Storage::disk($disk);
        if ($storage->exists($file_path)) {
            $storage->delete($file_path);
        }
        // $storage->put($file_path, $pdf->output(), 'public');
    }

    public static function sendEmail(ArInvoiceModel $invoice, $with_automation = false)
    {
        $log = applog('erp, ar_invoice__fac, send_email');
        $log->save('debug');

        // collecting
        $invoice->load([
            'invoice_customers:id,ar_invoice_id',
            'invoice_customers.invoice_customer_products' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_payment_scheme_name',
                    'ar_invoice_customer_id',
                    'customer_product_id',
                ]);
            },
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_product_id',
                ]);
            },
            'invoice_customers.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
            'payer_ref:id,user_id',
            'payer_ref.emails:id,name,customer_id',
        ]);

        // previous month's has been paid?
        if (
            $invoice->scheme &&
            $invoice->scheme
            ->invoices()
            ->where('date', '<', $invoice->date)
            ->where('paid', false)
            ->exists()
        ) {
            return false;
        }

        $invoice_ref = $invoice;
        $invoice = $invoice_ref->toArray();

        // mapping
        $invoice['company_name'] = $invoice['receiver_name'];
        $invoice['company_address'] = $invoice['receiver_address'];
        $invoice['company_postal_code'] = $invoice['receiver_postal_code'];
        $invoice['company_phone_number'] = $invoice['receiver_phone_number'];
        $invoice['company_fax'] = $invoice['receiver_fax'];
        $invoice['company_email'] = $invoice['receiver_email'];

        $invoice['customer_name'] = $invoice['payer_name'];
        $invoice['customer_address'] = $invoice['payer_address'];
        $invoice['customer_postal_code'] = $invoice['payer_postal_code'];
        $invoice['customer_phone_number'] = $invoice['payer_phone_number'];
        $invoice['customer_email'] = $invoice['payer_email'];
        $invoice['customer_cid'] = $invoice['payer_cid'];

        $invoice['billing_start_date'] = null;
        $invoice['billing_end_date'] = null;

        $invoice['billing_start_date_en'] = null;
        $invoice['billing_end_date_en'] = null;

        $invoice['customers'] = collect($invoice['invoice_customers'])->map(function ($customer) use (&$invoice) {
            $customer['products'] = collect($customer['invoice_customer_products'])->map(function ($product) use (&$invoice) {
                $product['additionals'] = collect($product['invoice_customer_product_additionals'])->map(function ($additional) {
                    $additional['price'] = number_format($additional['price'], 0, ',', '.');

                    return $additional;
                })->all();
                unset($product['invoice_customer_product_additionals']);
                if ($product['customer_product_payment_scheme_name'] === 'Monthly') {
                    $start_date = Carbon::createFromFormat('Y-m-d', $product['billing_start_date']);
                    $end_date = Carbon::createFromFormat('Y-m-d', $product['billing_end_date']);

                    $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');

                    $invoice['billing_start_date_en'] = $start_date->format('d F Y');
                    $invoice['billing_end_date_en'] = $end_date->format('d F Y');
                }

                $product['price'] = number_format($product['price'], 0, ',', '.');

                return $product;
            })->all();
            unset($customer['invoice_customer_products']);

            $customer['additionals'] = collect($customer['invoice_customer_product_additionals'])->map(function ($additional) use (&$invoice) {
                if ($additional['customer_product_additional_payment_scheme_name'] === 'Monthly') {
                    $start_date = Carbon::createFromFormat('Y-m-d', $additional['billing_start_date']);
                    $end_date = Carbon::createFromFormat('Y-m-d', $additional['billing_end_date']);

                    $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');

                    $invoice['billing_start_date_en'] = $start_date->format('d F Y');
                    $invoice['billing_end_date_en'] = $end_date->format('d F Y');
                }

                $additional['price'] = number_format($additional['price'], 0, ',', '.');

                return $additional;
            })->all();
            unset($customer['invoice_customer_product_additionals']);

            return $customer;
        })->all();
        unset($invoice['invoice_customers']);

        $date = Carbon::createFromFormat('Y-m-d', $invoice['date']);
        $due_date = Carbon::createFromFormat('Y-m-d', $invoice['due_date']);
        $billing_date = Carbon::createFromFormat('Y-m-d', $invoice['billing_date']);

        $invoice['date'] = $date->translatedFormat('d F Y');
        $invoice['due_date'] = $due_date->translatedFormat('d F Y');
        $invoice['billing_date'] = $billing_date->translatedFormat('d F Y');

        $invoice['date_en'] = $date->format('d F Y');
        $invoice['due_date_en'] = $due_date->format('d F Y');
        $invoice['billing_date_en'] = $billing_date->format('d F Y');

        $prevRemainingIsPositive = $invoice['previous_remaining_payment'] >= 0;

        $invoice['discount'] = number_format($invoice['discount'], 0, ',', '.');
        $invoice['tax_base'] = number_format($invoice['tax_base'], 0, ',', '.');
        $invoice['tax'] = number_format($invoice['tax'], 0, ',', '.');
        $invoice['previous_remaining_payment'] = number_format($invoice['previous_remaining_payment'], 0, ',', '.');
        $invoice['total'] = number_format($invoice['total'], 0, ',', '.');

        if ($prevRemainingIsPositive) {
            $invoice['previous_remaining_payment'] = '- '.$invoice['previous_remaining_payment'];
        }

        $to = null;
        $cc = collect();

        $payer_ref = $invoice_ref->payer_ref;

        if ($payer_ref) {
            $payer_ref->emails->each(function ($email, $key) use (&$to, &$cc) {
                if ($key === 0) {
                    $to = $email->name;

                    return true;
                }

                $cc->push($email->name);
            });
        }
        if (! $to) {
            return false;
        }

        $cc = $cc->all();

        $log->new()->properties(['to' => $to, 'cc' => $cc])->save('email address');

        try {
            $default_mail = Mail::getSwiftMailer();
            $invoice_mail = MailFac::getSwiftMailer('internet_retail_billing');
            if (in_array(FacadesApp::environment(), ['development', 'testing'])) {
                $to = config('app.dev_mail_address');
                $cc = config('app.dev_cc_mail_address');
                $invoice_mail = MailFac::getSwiftMailer('dev');
            }
            Mail::setSwiftMailer($invoice_mail);

            Mail::to($to)->cc($cc)->send(new Mailable([
                'invoice' => $invoice,
            ]));

            Mail::setSwiftMailer($default_mail);

            $invoice_ref->update([
                'email_sent' => true,
                'email_sent_at' => Carbon::now()->toDateTimeString(),
            ]);

            $invoice_ref->refresh();
            Customer::updateInstallationInvoiceEmailDate($invoice_ref);

            return true;
        } catch (\Exception $e) {
            $log->new()->properties($e->getMessage())->save('error');

            return false;
        }
    }

    public static function sendReminderEmail(ArInvoiceModel $invoice, $with_automation = false)
    {
        $log = applog('erp, ar_invoice__fac, send_reminder_email');
        $log->save('debug');

        // collecting
        $invoice->load([
            'invoice_customers:id,ar_invoice_id',
            'invoice_customers.invoice_customer_products' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_product_id',
                ]);
            },
            'invoice_customers.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
            'payer_ref:id,user_id',
            'payer_ref.emails:id,name,customer_id',
        ]);

        $invoice_ref = $invoice;
        $invoice = $invoice_ref->toArray();

        // mapping
        $invoice['company_name'] = $invoice['receiver_name'];
        $invoice['company_address'] = $invoice['receiver_address'];
        $invoice['company_postal_code'] = $invoice['receiver_postal_code'];
        $invoice['company_phone_number'] = $invoice['receiver_phone_number'];
        $invoice['company_fax'] = $invoice['receiver_fax'];
        $invoice['company_email'] = $invoice['receiver_email'];

        $invoice['customer_name'] = $invoice['payer_name'];
        $invoice['customer_address'] = $invoice['payer_address'];
        $invoice['customer_postal_code'] = $invoice['payer_postal_code'];
        $invoice['customer_phone_number'] = $invoice['payer_phone_number'];
        $invoice['customer_email'] = $invoice['payer_email'];
        $invoice['customer_cid'] = $invoice['payer_cid'];

        $invoice['billing_start_date'] = null;
        $invoice['billing_end_date'] = null;

        $invoice['billing_start_date_en'] = null;
        $invoice['billing_end_date_en'] = null;

        $invoice['customers'] = collect($invoice['invoice_customers'])->map(function ($customer) use (&$invoice) {
            $customer['products'] = collect($customer['invoice_customer_products'])->map(function ($product) use (&$invoice) {
                $product['additionals'] = collect($product['invoice_customer_product_additionals'])->map(function ($additional) {
                    $additional['price'] = number_format($additional['price'], 0, ',', '.');

                    return $additional;
                })->all();
                unset($product['invoice_customer_product_additionals']);

                if ($product['customer_product_payment_scheme_name'] === 'Monthly') {
                    $start_date = Carbon::createFromFormat('Y-m-d', $product['billing_start_date']);
                    $end_date = Carbon::createFromFormat('Y-m-d', $product['billing_end_date']);

                    $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');

                    $invoice['billing_start_date_en'] = $start_date->format('d F Y');
                    $invoice['billing_end_date_en'] = $end_date->format('d F Y');
                }

                $product['price'] = number_format($product['price'], 0, ',', '.');

                return $product;
            })->all();
            unset($customer['invoice_customer_products']);

            $customer['additionals'] = collect($customer['invoice_customer_product_additionals'])->map(function ($additional) use (&$invoice) {
                if ($additional['customer_product_additional_payment_scheme_name'] === 'Monthly') {
                    $start_date = Carbon::createFromFormat('Y-m-d', $additional['billing_start_date']);
                    $end_date = Carbon::createFromFormat('Y-m-d', $additional['billing_end_date']);

                    $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');

                    $invoice['billing_start_date_en'] = $start_date->format('d F Y');
                    $invoice['billing_end_date_en'] = $end_date->format('d F Y');
                }

                $additional['price'] = number_format($additional['price'], 0, ',', '.');

                return $additional;
            })->all();
            unset($customer['invoice_customer_product_additionals']);

            return $customer;
        })->all();
        unset($invoice['invoice_customers']);

        $date = Carbon::createFromFormat('Y-m-d', $invoice['date']);
        $due_date = Carbon::createFromFormat('Y-m-d', $invoice['due_date']);
        $billing_date = Carbon::createFromFormat('Y-m-d', $invoice['billing_date']);

        $invoice['date'] = $date->translatedFormat('d F Y');
        $invoice['due_date'] = $due_date->translatedFormat('d F Y');
        $invoice['billing_date'] = $billing_date->translatedFormat('d F Y');

        $invoice['date_en'] = $date->format('d F Y');
        $invoice['due_date_en'] = $due_date->format('d F Y');
        $invoice['billing_date_en'] = $billing_date->format('d F Y');

        $prevRemainingIsPositive = $invoice['previous_remaining_payment'] >= 0;

        $invoice['discount'] = number_format($invoice['discount'], 0, ',', '.');
        $invoice['tax_base'] = number_format($invoice['tax_base'], 0, ',', '.');
        $invoice['tax'] = number_format($invoice['tax'], 0, ',', '.');
        $invoice['previous_remaining_payment'] = number_format($invoice['previous_remaining_payment'], 0, ',', '.');
        $invoice['total'] = number_format($invoice['total'], 0, ',', '.');

        if ($prevRemainingIsPositive) {
            $invoice['previous_remaining_payment'] = '- '.$invoice['previous_remaining_payment'];
        }

        $to = null;
        $cc = collect();

        $payer_ref = $invoice_ref->payer_ref;

        if ($payer_ref) {
            $payer_ref->emails->each(function ($email, $key) use (&$to, &$cc) {
                if ($key === 0) {
                    $to = $email->name;

                    return true;
                }

                $cc->push($email->name);
            });
        }
        if (! $to) {
            return false;
        }

        $cc = $cc->all();

        $log->new()->properties(['to' => $to, 'cc' => $cc])->save('email address');

        try {
            $default_mail = Mail::getSwiftMailer();
            $invoice_reminder_mail = MailFac::getSwiftMailer('internet_retail_billing');
            if (in_array(FacadesApp::environment(), ['development', 'testing'])) {
                $to = config('app.dev_mail_address');
                $cc = config('app.dev_cc_mail_address');
                $invoice_reminder_mail = MailFac::getSwiftMailer('dev');
            }
            Mail::setSwiftMailer($invoice_reminder_mail);

            Mail::to($to)->cc($cc)->send(new ReminderMail([
                'invoice' => $invoice,
            ]));

            Mail::setSwiftMailer($default_mail);

            $invoice_ref->update([
                'email_reminder_sent' => true,
                'email_reminder_sent_at' => Carbon::now()->toDateTimeString(),
            ]);

            return true;
        } catch (\Exception $e) {
            $log->new()->properties($e->getMessage())->save('error');

            return false;
        }
    }

    public static function sendReceiptEmail(ArInvoiceModel $invoice)
    {
        $log = applog('erp, ar_invoice__fac, send_receipt_email');
        $log->save('debug');

        // collecting
        $invoice->load([
            'invoice_customers:id,ar_invoice_id',
            'invoice_customers.invoice_customer_products' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_product_id',
                ]);
            },
            'invoice_customers.invoice_customer_product_additionals' => function ($query) {
                $query->select([
                    'id',
                    'customer_product_additional_name as name',
                    'price',
                    'billing_start_date',
                    'billing_end_date',
                    'customer_product_additional_payment_scheme_name',
                    'ar_invoice_customer_id',
                ]);
            },
            'payer_ref:id,user_id',
            'payer_ref.emails:id,name,customer_id',
        ]);

        $invoice_ref = $invoice;
        $invoice = $invoice_ref->toArray();

        // mapping
        $invoice['company_name'] = $invoice['receiver_name'];
        $invoice['company_address'] = $invoice['receiver_address'];
        $invoice['company_postal_code'] = $invoice['receiver_postal_code'];
        $invoice['company_phone_number'] = $invoice['receiver_phone_number'];
        $invoice['company_fax'] = $invoice['receiver_fax'];
        $invoice['company_email'] = $invoice['receiver_email'];

        $invoice['customer_name'] = $invoice['payer_name'];
        $invoice['customer_address'] = $invoice['payer_address'];
        $invoice['customer_postal_code'] = $invoice['payer_postal_code'];
        $invoice['customer_phone_number'] = $invoice['payer_phone_number'];
        $invoice['customer_email'] = $invoice['payer_email'];
        $invoice['customer_cid'] = $invoice['payer_cid'];

        $invoice['billing_start_date'] = null;
        $invoice['billing_end_date'] = null;

        $invoice['billing_start_date_en'] = null;
        $invoice['billing_end_date_en'] = null;

        $invoice['customers'] = collect($invoice['invoice_customers'])->map(function ($customer) use (&$invoice) {
            $customer['products'] = collect($customer['invoice_customer_products'])->map(function ($product) use (&$invoice) {
                $product['additionals'] = collect($product['invoice_customer_product_additionals'])->map(function ($additional) {
                    $additional['price'] = number_format($additional['price'], 0, ',', '.');

                    return $additional;
                })->all();
                unset($product['invoice_customer_product_additionals']);

                if ($product['customer_product_payment_scheme_name'] === 'Monthly') {
                    $start_date = Carbon::createFromFormat('Y-m-d', $product['billing_start_date']);
                    $end_date = Carbon::createFromFormat('Y-m-d', $product['billing_end_date']);

                    $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');

                    $invoice['billing_start_date_en'] = $start_date->format('d F Y');
                    $invoice['billing_end_date_en'] = $end_date->format('d F Y');
                }

                $product['price'] = number_format($product['price'], 0, ',', '.');

                return $product;
            })->all();
            unset($customer['invoice_customer_products']);

            $customer['additionals'] = collect($customer['invoice_customer_product_additionals'])->map(function ($additional) use (&$invoice) {
                if ($additional['customer_product_additional_payment_scheme_name'] === 'Monthly') {
                    $start_date = Carbon::createFromFormat('Y-m-d', $additional['billing_start_date']);
                    $end_date = Carbon::createFromFormat('Y-m-d', $additional['billing_end_date']);

                    $invoice['billing_start_date'] = $start_date->translatedFormat('d F Y');
                    $invoice['billing_end_date'] = $end_date->translatedFormat('d F Y');

                    $invoice['billing_start_date_en'] = $start_date->format('d F Y');
                    $invoice['billing_end_date_en'] = $end_date->format('d F Y');
                }

                $additional['price'] = number_format($additional['price'], 0, ',', '.');

                return $additional;
            })->all();
            unset($customer['invoice_customer_product_additionals']);

            return $customer;
        })->all();
        unset($invoice['invoice_customers']);

        $date = Carbon::createFromFormat('Y-m-d', $invoice['date']);
        $due_date = Carbon::createFromFormat('Y-m-d', $invoice['due_date']);
        $billing_date = Carbon::createFromFormat('Y-m-d', $invoice['billing_date']);

        $invoice['date'] = $date->translatedFormat('d F Y');
        $invoice['due_date'] = $due_date->translatedFormat('d F Y');
        $invoice['billing_date'] = $billing_date->translatedFormat('d F Y');

        $invoice['date_en'] = $date->format('d F Y');
        $invoice['due_date_en'] = $due_date->format('d F Y');
        $invoice['billing_date_en'] = $billing_date->format('d F Y');

        $prevRemainingIsPositive = $invoice['previous_remaining_payment'] >= 0;

        $invoice['discount'] = number_format($invoice['discount'], 0, ',', '.');
        $invoice['tax_base'] = number_format($invoice['tax_base'], 0, ',', '.');
        $invoice['tax'] = number_format($invoice['tax'], 0, ',', '.');
        $invoice['previous_remaining_payment'] = number_format($invoice['previous_remaining_payment'], 0, ',', '.');
        $invoice['total'] = number_format($invoice['total'], 0, ',', '.');

        if ($prevRemainingIsPositive) {
            $invoice['previous_remaining_payment'] = '- '.$invoice['previous_remaining_payment'];
        }

        $to = null;
        $cc = collect();

        $payer_ref = $invoice_ref->payer_ref;

        if ($payer_ref) {
            $payer_ref->emails->each(function ($email, $key) use (&$to, &$cc) {
                if ($key === 0) {
                    $to = $email->name;

                    return true;
                }

                $cc->push($email->name);
            });
        }
        if (! $to) {
            return false;
        }

        $cc = $cc->all();

        $log->new()->properties(['to' => $to, 'cc' => $cc])->save('email address');

        try {
            $default_mail = Mail::getSwiftMailer();
            $invoice_reminder_mail = MailFac::getSwiftMailer('internet_retail_billing');
            if (in_array(FacadesApp::environment(), ['development', 'testing'])) {
                $to = config('app.dev_mail_address');
                $cc = config('app.dev_cc_mail_address');
                $invoice_reminder_mail = MailFac::getSwiftMailer('dev');
            }
            Mail::setSwiftMailer($invoice_reminder_mail);

            Mail::to($to)->cc($cc)->send(new ReceiptMail([
                'invoice' => $invoice,
            ]));

            Mail::setSwiftMailer($default_mail);

            $invoice_ref->update([
                'email_receipt_sent' => true,
                'email_receipt_sent_at' => Carbon::now()->toDateTimeString(),
            ]);

            return true;
        } catch (\Exception $e) {
            $log->new()->properties($e->getMessage())->save('error');

            return false;
        }
    }

    public static function sendWhatsapp(ArInvoiceModel $invoice, $with_automation = false)
    {
        $log = applog('erp, ar_invoice__fac, send_whatsapp');
        $log->save('debug');

        $invoice->load([
            'payer_ref',
            'payer_ref.phone_numbers',
        ]);

        // previous month's has been paid?
        if (
            $invoice->scheme &&
            $invoice->scheme
            ->invoices()
            ->where('date', '<', $invoice->date)
            ->where('paid', false)
            ->exists()
        ) {
            return false;
        }

        $phone_numbers = collect();
        $invoice->payer_ref->phone_numbers->each(function ($phone_number_ref) use (&$phone_numbers) {
            $phone_numbers->push($phone_number_ref->number);
        });

        if ($phone_numbers->isEmpty()) {
            $log->save('phone number empty');

            return false;
        }
        $phone_numbers = $phone_numbers->all();

        $template_name = 'installation_invoice_with_due_date';
        $parameters = [
            [
                'type' => 'text',
                'text' => $invoice->number,
            ],
            [
                'type' => 'text',
                'text' => number_format($invoice->total, 0, ',', '.'),
            ],
            [
                'type' => 'text',
                'text' => config('app.client_domain').'/pay'.'/'.$invoice->uuid,
            ],
            [
                'type' => 'text',
                'text' => $invoice->due_date->translatedFormat('D, j F Y'),
            ],
        ];

        if (! Str::contains($invoice->name, 'Installation')) {
            // template_namme
            $template_name = 'monthly_invoice_with_confirm';

            // parameters
            $start_period = null;
            $end_period = null;

            $invoice->invoice_customers->each(function ($invoice_customer) use (&$start_period, &$end_period) {
                $invoice_customer->invoice_customer_products->each(function ($invoice_customer_product) use (&$start_period, &$end_period) {
                    if ($invoice_customer_product->customer_product_payment_scheme_name === 'Monthly') {
                        $start_period = $invoice_customer_product->billing_start_date;
                        $end_period = $invoice_customer_product->billing_end_date;
                    }
                });
            });

            $period = '-';
            if ($start_period && $end_period) {
                if ($start_period->isSameMonth($end_period)) {
                    $period = $start_period->translatedFormat('F');
                }
                $period = $start_period->translatedFormat('F').' - '.$end_period->translatedFormat('F');
            }
            array_unshift($parameters, [
                'type' => 'text',
                'text' => $period,
            ]);
        }

        $storage = Storage::disk(config('filesystems.primary_disk'));
        $pdf_path = 'invoice/'.str_replace('/', '_', $invoice->number).'.pdf';

        $pdf_url = $storage->url($pdf_path);
        $pdf_filename = str_replace('/', '_', $invoice->number).'.pdf';

        $components = [
            [
                'type' => 'header',
                'parameters' => [
                    [
                        'type' => 'document',
                        'document' => [
                            'link' => $pdf_url,
                            'filename' => $pdf_filename,
                        ],
                    ],
                ],
            ],
            [
                'type' => 'body',
                'parameters' => $parameters,
            ],
        ];

        $success = Whatsapp::sendMultipleReceivers(
            $template_name,
            null,
            $phone_numbers,
            false,
            $components,
            function ($response_body) use ($invoice) {
                ArInvoiceWhatsapp::create([
                    'ar_invoice_id' => $invoice->id,
                    'message_id' => isset($response_body->messages[0]) ? $response_body->messages[0]->id : null,
                ]);
            }
        );

        if ($success) {
            $invoice->whatsapp_sent = true;
            $invoice->whatsapp_sent_at = Carbon::now()->toDateTimeString();
            $invoice->save();

            $invoice->refresh();
            Customer::updateInstallationInvoiceWhatsappDate($invoice);

            // $data = $response_body->data;

            // ArInvoiceWhatsapp::create([
            //     'ar_invoice_id' => $invoice->id,
            //     'broadcast_job_id' => $data->broadcast_job_id,
            //     'response_log_status' => $data->broadcast_logs[0]->status,
            // ]);

            // dispatch(new ArInvoiceQiscusGetWhatsapp($invoice->id, $data->broadcast_job_id))->delay(now()->addMinutes(10));
        }

        return $success;
    }

    public static function qiscusGetWhatsapp(ArInvoiceModel $invoice, $broadcast_job_id)
    {
        $log = applog('erp, ar_invoice__fac, qisqus_get_whatsapp');
        $log->save('debug');

        $url = 'https://multichannel.qiscus.com/api/v2/admin/broadcast_jobs/'.$broadcast_job_id;
        $request = new GuzzleRequest('GET', $url, [
            'Authorization' => config('app.qisqus_admin_token'),
            'Content-Type' => 'application/json',
            'Qiscus-App-Id' => config('app.qisqus_app_code'),
        ]);
        $response = (new GuzzleClient())->sendRequest($request);

        // handling response
        $response_body = json_decode($response->getBody()->getContents());

        if ($response_body->status === 200) {
            $broadcast_job = $response_body->data->broadcast_job;
            $whatsapp = $invoice->whatsapps()->where('broadcast_job_id', $broadcast_job_id)->first();

            if ($whatsapp) {
                $whatsapp->update([
                    'broadcast_name' => $broadcast_job->name,
                    'job_status' => $broadcast_job->status,

                    'job_total_failed' => $broadcast_job->total_failed,
                    'job_total_read' => $broadcast_job->total_read,
                    'job_total_received' => $broadcast_job->total_received,
                    'job_total_recipient' => $broadcast_job->total_recipient,
                    'job_total_sent' => $broadcast_job->total_sent,
                ]);
            }
        }
    }

    public static function sendReminderWhatsapp(ArInvoiceModel $invoice, $with_automation = false)
    {
        $log = applog('erp, ar_invoice__fac, send_reminder_whatsapp');
        $log->save('debug');

        $invoice->load([
            'payer_ref',
            'payer_ref.phone_numbers',
        ]);

        $phone_numbers = collect();
        $invoice->payer_ref->phone_numbers->each(function ($phone_number_ref) use (&$phone_numbers) {
            $phone_numbers->push($phone_number_ref->number);
        });

        if ($phone_numbers->isEmpty()) {
            $log->save('phone number empty');

            return false;
        }
        $phone_numbers = $phone_numbers->all();

        $template_name = 'payment_reminder_with_due_date';
        $parameters = [
            [
                'type' => 'text',
                'text' => $invoice->number,
            ],
            [
                'type' => 'text',
                'text' => $invoice->due_date->translatedFormat('d F Y'),
            ],
            [
                'type' => 'text',
                'text' => config('app.client_domain').'/pay'.'/'.$invoice->uuid,
            ],
            [
                'type' => 'text',
                'text' => $invoice->due_date->translatedFormat('d F Y'),
            ],
        ];
        $components = [
            [
                'type' => 'header',
                'parameters' => [
                    [
                        'type' => 'document',
                        'document' => [
                            'link' => config('app.retail_internet_payment_guide_file'),
                            'filename' => config('app.retail_internet_payment_guide_filename'),
                        ],
                    ],
                ],
            ],
            [
                'type' => 'body',
                'parameters' => $parameters,
            ],
        ];

        $success = Whatsapp::sendMultipleReceivers(
            $template_name,
            null,
            $phone_numbers,
            false,
            $components,
            function ($response_body) use ($invoice) {
                ArInvoiceWhatsappReminder::create([
                    'ar_invoice_id' => $invoice->id,
                    'message_id' => isset($response_body->messages[0]) ? $response_body->messages[0]->id : null,
                ]);
            }
        );

        if ($success) {
            $invoice->reminder_whatsapp_sent = true;
            $invoice->reminder_whatsapp_sent_at = Carbon::now()->toDateTimeString();

            if (! $invoice->reminder_whatsapp_count) {
                $invoice->reminder_whatsapp_count = 0;
            }
            $invoice->reminder_whatsapp_count += 1;

            $invoice->save();

            // $data = $response_body->data;

            // ArInvoiceWhatsappReminder::create([
            //     'ar_invoice_id' => $invoice->id,
            //     'broadcast_job_id' => $data->broadcast_job_id,
            //     'response_log_status' => $data->broadcast_logs[0]->status,
            // ]);

            // dispatch(new ArInvoiceQiscusGetWhatsappReminder($invoice->id, $data->broadcast_job_id))->delay(now()->addMinutes(10));
        }

        return $success;
    }

    public static function qiscusGetWhatsappReminder(ArInvoiceModel $invoice, $broadcast_job_id)
    {
        $log = applog('erp, ar_invoice__fac, qisqus_get_whatsapp_reminder');
        $log->save('debug');

        $url = 'https://multichannel.qiscus.com/api/v2/admin/broadcast_jobs/'.$broadcast_job_id;
        $request = new GuzzleRequest('GET', $url, [
            'Authorization' => config('app.qisqus_admin_token'),
            'Content-Type' => 'application/json',
            'Qiscus-App-Id' => config('app.qisqus_app_code'),
        ]);
        $response = (new GuzzleClient())->sendRequest($request);

        // handling response
        $response_body = json_decode($response->getBody()->getContents());

        if ($response_body->status === 200) {
            $broadcast_job = $response_body->data->broadcast_job;
            $whatsapp_reminder = $invoice->whatsapp_reminders()->where('broadcast_job_id', $broadcast_job_id)->first();

            if ($whatsapp_reminder) {
                $whatsapp_reminder->update([
                    'broadcast_name' => $broadcast_job->name,
                    'job_status' => $broadcast_job->status,

                    'job_total_failed' => $broadcast_job->total_failed,
                    'job_total_read' => $broadcast_job->total_read,
                    'job_total_received' => $broadcast_job->total_received,
                    'job_total_recipient' => $broadcast_job->total_recipient,
                    'job_total_sent' => $broadcast_job->total_sent,
                ]);
            }
        }
    }

    public static function sendReceiptWhatsapp(ArInvoiceModel $invoice)
    {
        $log = applog('erp, ar_invoice__fac, send_receipt_whatsapp');
        $log->save('debug');

        $invoice->load([
            'payer_ref',
            'payer_ref.phone_numbers',
        ]);

        $phone_numbers = collect();
        $invoice->payer_ref->phone_numbers->each(function ($phone_number_ref) use (&$phone_numbers) {
            $phone_numbers->push($phone_number_ref->number);
        });

        if ($phone_numbers->isEmpty()) {
            $log->save('phone number empty');

            return false;
        }
        $phone_numbers = $phone_numbers->all();

        $storage = Storage::disk(config('filesystems.primary_disk'));
        $pdf_path = 'invoice_receipt/'.str_replace('/', '_', $invoice['number']).'.pdf';

        $pdf_url = $storage->url($pdf_path);
        $pdf_filename = str_replace('/', '_', $invoice['number']).'.pdf';

        $template_name = 'invoice_receipt';
        $components = [
            [
                'type' => 'header',
                'parameters' => [
                    [
                        'type' => 'document',
                        'document' => [
                            'link' => $pdf_url,
                            'filename' => $pdf_filename,
                        ],
                    ],
                ],
            ],
            [
                'type' => 'body',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $invoice->number,
                    ],
                ],
            ],
        ];

        $success = Whatsapp::sendMultipleReceivers(
            $template_name,
            null,
            $phone_numbers,
            false,
            $components,
            function ($response_body) use ($invoice) {
                ArInvoiceWhatsappReceipt::create([
                    'ar_invoice_id' => $invoice->id,
                    'message_id' => isset($response_body->messages[0]) ? $response_body->messages[0]->id : null,
                ]);
            }
        );

        if ($success) {
            $invoice->receipt_whatsapp_sent = true;
            $invoice->receipt_whatsapp_sent_at = Carbon::now()->toDateTimeString();
            $invoice->save();

            // $data = $response_body->data;

            // ArInvoiceWhatsappReceipt::create([
            //     'ar_invoice_id' => $invoice->id,
            //     'broadcast_job_id' => $data->broadcast_job_id,
            //     'response_log_status' => $data->broadcast_logs[0]->status,
            // ]);

            // dispatch(new ArInvoiceQiscusGetWhatsappReceipt($invoice->id, $data->broadcast_job_id))->delay(now()->addMinutes(10));
        }

        return $success;
    }

    public static function qiscusGetWhatsappReceipt(ArInvoiceModel $invoice, $broadcast_job_id)
    {
        $log = applog('erp, ar_invoice__fac, qisqus_get_whatsapp_reminder');
        $log->save('debug');

        $url = 'https://multichannel.qiscus.com/api/v2/admin/broadcast_jobs/'.$broadcast_job_id;
        $request = new GuzzleRequest('GET', $url, [
            'Authorization' => config('app.qisqus_admin_token'),
            'Content-Type' => 'application/json',
            'Qiscus-App-Id' => config('app.qisqus_app_code'),
        ]);
        $response = (new GuzzleClient())->sendRequest($request);

        // handling response
        $response_body = json_decode($response->getBody()->getContents());

        if ($response_body->status === 200) {
            $broadcast_job = $response_body->data->broadcast_job;
            $whatsapp_receipt = $invoice->whatsapp_receipts()->where('broadcast_job_id', $broadcast_job_id)->first();

            if ($whatsapp_receipt) {
                $whatsapp_receipt->update([
                    'broadcast_name' => $broadcast_job->name,
                    'job_status' => $broadcast_job->status,

                    'job_total_failed' => $broadcast_job->total_failed,
                    'job_total_read' => $broadcast_job->total_read,
                    'job_total_received' => $broadcast_job->total_received,
                    'job_total_recipient' => $broadcast_job->total_recipient,
                    'job_total_sent' => $broadcast_job->total_sent,
                ]);
            }
        }
    }

    public static function updateBillingEndDateIndex(ArInvoiceModel $invoice)
    {
        $log = applog('erp, ar_invoice__fac, update_billing_end_date_index');
        $log->save('debug');

        $scheme = $invoice->scheme;
        if (! $scheme) {
            return;
        }

        // installation
        $installation = Str::contains($scheme->name, 'Installation');

        // customer_product
        $customer_product = null;

        if ($installation) {
            $scheme_customer_product_additional = $scheme->scheme_customers->first()
                ->scheme_customer_product_additionals->first();

            if ($scheme_customer_product_additional) {
                $customer_product = $scheme_customer_product_additional
                    ->customer_product_additional
                    ->customer_product;
            }
        } else {
            $scheme_customer_product = $scheme->scheme_customers->first()
                ->scheme_customer_products->first();

            if ($scheme_customer_product) {
                $customer_product = $scheme_customer_product->customer_product;
            }
        }
        if (! $customer_product) {
            return;
        }

        // updating invoice
        $invoice->update(['billing_end_date' => $customer_product->billing_end_date]);
    }

    public static function updateJsonProductTag(ArInvoiceModel $invoice)
    {
        $log = applog('erp, ar_invoice__fac, update_json_product');
        $log->save('debug');

        $scheme = $invoice->scheme;
        if (! $scheme) {
            return;
        }

        // installation
        $installation = Str::contains($scheme->name, 'Installation');

        // customer_product
        $customer_product = null;

        if ($installation) {
            $scheme_customer_product_additional = $scheme->scheme_customers->first()
                ->scheme_customer_product_additionals->first();

            if ($scheme_customer_product_additional) {
                $customer_product = $scheme_customer_product_additional
                    ->customer_product_additional
                    ->customer_product;
            }
        } else {
            $scheme_customer_product = $scheme->scheme_customers->first()
                ->scheme_customer_products->first();

            if ($scheme_customer_product) {
                $customer_product = $scheme_customer_product->customer_product;
            }
        }
        if (! $customer_product) {
            return;
        }

        $product_tags = [];
        if (! $customer_product->product) {
            return;
        }

        $customer_product->product->tags->each(function ($tag) use (&$product_tags) {
            array_push($product_tags, ['id' => $tag->id]);
        });

        $invoice->update(['json_product_tags' => json_encode($product_tags)]);
    }

    public static function updateSubsidy(ArInvoiceModel $invoice)
    {
        $log = applog('erp, ar_invoice__fac, update_subsidy');
        $log->save('debug');

        $scheme = $invoice->scheme;
        if (! $scheme) {
            return;
        }

        // installation
        $installation = Str::contains($scheme->name, 'Installation');

        // customer_product
        $customer_product = null;

        if ($installation) {
            $scheme_customer_product_additional = $scheme->scheme_customers->first()
                ->scheme_customer_product_additionals->first();

            if ($scheme_customer_product_additional) {
                $customer_product = $scheme_customer_product_additional
                    ->customer_product_additional
                    ->customer_product;
            }
        } else {
            $scheme_customer_product = $scheme->scheme_customers->first()
                ->scheme_customer_products->first();

            if ($scheme_customer_product) {
                $customer_product = $scheme_customer_product->customer_product;
            }
        }
        if (! $customer_product) {
            return;
        }
        if (! $customer_product->product) {
            return;
        }

        $subsidy = false;
        if (Str::contains($customer_product->product->name, 'Subsidy')) {
            $subsidy = true;
        }

        $invoice->update(['subsidy' => $subsidy]);
    }

    public static function createMonthly()
    {
        $log = applog('erp, ar_invoice__fac, create_monthly');
        $log->save('debug');

        foreach (ArInvoiceSchemeModel::where('ignore_prorated', false)
            ->where('name', 'not like', '%Installation%')
            ->cursor() as $scheme) {
            if (
                ! $scheme->invoices()
                    ->whereMonth('billing_date', Carbon::now()->month)
                    ->whereYear('billing_date', Carbon::now()->year)
                    ->exists()
            ) {
                static::createOrUpdate($scheme, true);
            }
        }
    }

    public static function createDaily()
    {
        $log = applog('erp, ar_invoice__fac, create_daily');
        $log->save('debug');

        foreach (ArInvoiceSchemeModel::where('ignore_prorated', true)
            ->where('name', 'not like', '%Installation%')
            ->cursor() as $scheme) {
            if (
                ! $scheme->invoices()
                    ->whereMonth('billing_date', Carbon::now()->month)
                    ->whereYear('billing_date', Carbon::now()->year)
                    ->exists()
            ) {
                static::createOrUpdate($scheme, true);
            }
        }
    }

    public static function createWasNotCreated()
    {
        $log = applog('erp, ar_invoice__fac, create_was_not_created');
        $log->save('debug');

        $billing_date = Carbon::now()->toImmutable();

        $month = $billing_date->month;
        $year = $billing_date->year;
        /**
         * postpaid
         * - non_prorated
         */
        $postpaid__non_prorated__start_date = function ($date) use ($year, $month) {
            return "date_sub(
                makedate(
                    year('".$year.'-'.$month."-01'),
                    (
                        dayofyear('".$year.'-'.$month."-01') - 1 +
                        if(
                            dayofmonth(".$date.') > 28,
                            1,
                            dayofmonth('.$date.')
                        )
                    )
                ),
                interval 1 month
            )';
        };
        $postpaid__non_prorated__end_date = function ($date) use ($year, $month) {
            return "date_sub(date_add(date_sub(
                makedate(
                    year('".$year.'-'.$month."-01'),
                    (
                        dayofyear('".$year.'-'.$month."-01') - 1 +
                        if(
                            dayofmonth(".$date.') > 28,
                            1,
                            dayofmonth('.$date.')
                        )
                    )
                ),
                interval 1 month
            ), interval 1 month), interval 1 day)';
        };

        /**
         * postpaid
         * - prorated
         *
         * billing_date = ?
         * billing_start_date = date_sub(date('".$year."-".$month."-01'), interval 1 month)
         */
        $postpaid__prorated__start_date = "date_sub(
            date('".$year.'-'.$month."-01'),
            interval 1 month
        )";
        $postpaid__prorated__end_date = "last_day(
            date_sub(
                date('".$year.'-'.$month."-01'),
                interval 1 month
            )
        )";

        /**
         * non_postpaid
         * - non_prorated
         *
         * billing_date = ?
         * billing_start_date = date('".$year."-".$month."-01')
         */
        $non_postpaid__non_prorated__start_date = function ($date) use ($year, $month) {
            return "makedate(
                year('".$year.'-'.$month."-01'),
                (
                    dayofyear('".$year.'-'.$month."-01') - 1 +
                    if(
                        dayofmonth(".$date.') > 28,
                        1,
                        dayofmonth('.$date.')
                    )
                )
            )';
        };
        $non_postpaid__non_prorated__end_date = function ($date) use ($year, $month) {
            return "date_sub(
                date_add(
                    makedate(
                        year('".$year.'-'.$month."-01'),
                        (
                            dayofyear('".$year.'-'.$month."-01') - 1 +
                            if(
                                dayofmonth(".$date.') > 28,
                                1,
                                dayofmonth('.$date.')
                            )
                        )
                    ),
                    interval 1 month
                ),
                interval 1 day
            )';
        };

        /**
         * non_postpaid
         * - prorated
         *
         * billing_date = ?
         * billing_start_date = date('".$year."-".$month."-01')
         */
        $non_postpaid__prorated__start_date = "date('".$year.'-'.$month."-01')";
        $non_postpaid__prorated__end_date = "last_day(
            date('".$year.'-'.$month."-01')
        )";

        // billing customer product
        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
                'product.price',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $billing__customer_product_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer_product.customer_id',

                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',

                'product.name as product_name',
                'product.payment_scheme_name as payment_scheme_name',

                'customer_product.ignore_prorated',
                'customer_product.postpaid',

                'customer_product.adjusted_price',
                'customer_product.special_price',
                'product.price as price',
            )
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            });

        $customers_query = DB::table('customer')
            ->select(
                'customer.id',
                'customer.name as customer_name',
                'customer.cid',
                DB::raw('((
                    select
                        count(customer_product.id)
                    from
                        ('.$billing__customer_product_query->toSql().") as customer_product
                    where
                        customer_product.customer_id = customer.id
                    and
                        (
                            case when
                                customer_product.payment_scheme_name = 'Monthly'
                            then
                                case when
                                    customer_product.billing_start_date is not null
                                then
                                    case when
                                        customer_product.billing_end_date is not null
                                    then
                                        case when
                                            customer_product.postpaid
                                        then
                                            case when
                                                customer_product.ignore_prorated
                                            then
                                                (
                                                    (customer_product.billing_start_date <= ".$postpaid__non_prorated__end_date('customer_product.billing_start_date').') and
                                                    (customer_product.billing_end_date >= '.$postpaid__non_prorated__start_date('customer_product.billing_start_date').')
                                                )
                                            else
                                                (
                                                    (customer_product.billing_start_date <= '.$postpaid__prorated__end_date.') and
                                                    (customer_product.billing_end_date >= '.$postpaid__prorated__start_date.')
                                                )
                                            end
                                        else
                                            case when
                                                customer_product.ignore_prorated
                                            then
                                                (
                                                    (customer_product.billing_start_date <= '.$non_postpaid__non_prorated__end_date('customer_product.billing_start_date').') and
                                                    (customer_product.billing_end_date >= '.$non_postpaid__non_prorated__start_date('customer_product.billing_start_date').')
                                                )
                                            else
                                                (
                                                    (customer_product.billing_start_date <= '.$non_postpaid__prorated__end_date.') and
                                                    (customer_product.billing_end_date >= '.$non_postpaid__prorated__start_date.')
                                                )
                                            end
                                        end
                                    else
                                        case when
                                            customer_product.postpaid
                                        then
                                            case when
                                                customer_product.ignore_prorated
                                            then
                                                (
                                                    (customer_product.billing_start_date <= '.$postpaid__non_prorated__end_date('customer_product.billing_start_date').') and
                                                    ('.$postpaid__non_prorated__end_date('customer_product.billing_start_date').' >= '.$postpaid__non_prorated__start_date('customer_product.billing_start_date').')
                                                )
                                            else
                                                (
                                                    (customer_product.billing_start_date <= '.$postpaid__prorated__end_date.') and
                                                    ('.$postpaid__prorated__end_date.' >= '.$postpaid__prorated__start_date.')
                                                )
                                            end
                                        else
                                            case when
                                                customer_product.ignore_prorated
                                            then
                                                (
                                                    (customer_product.billing_start_date <= '.$non_postpaid__non_prorated__end_date('customer_product.billing_start_date').') and
                                                    ('.$non_postpaid__non_prorated__end_date('customer_product.billing_start_date').' >= '.$non_postpaid__non_prorated__start_date('customer_product.billing_start_date').')
                                                )
                                            else
                                                (
                                                    (customer_product.billing_start_date <= '.$non_postpaid__prorated__end_date.') and
                                                    ('.$non_postpaid__prorated__end_date.' >= '.$non_postpaid__prorated__start_date.")
                                                )
                                            end
                                        end
                                    end
                                else
                                    false
                                end
                            else
                                case when
                                    customer_product.billing_date is not null
                                then
                                    (customer_product.billing_date between date('".$year.'-'.$month."-01') and last_day(date('".$year.'-'.$month."-01')))
                                else
                                    false
                                end
                            end
                        )
                    and
                        (
                            case when
                                (
                                    case when
                                        customer_product.adjusted_price
                                    then
                                        customer_product.special_price
                                    else
                                        customer_product.price
                                    end
                                ) > 0
                            then
                                true
                            else
                                false
                            end
                        )
                ) - (
                    select
                        count(ar_invoice.id)
                    from
                        ar_invoice
                    where
                        ar_invoice.payer = customer.id
                    and
                        (
                            case when
                                (ar_invoice.hybrid and ar_invoice.postpaid)
                            then
                                ar_invoice.due_date between date('".$year.'-'.$month."-01') and last_day(date('".$year.'-'.$month."-01'))
                            else
                                ar_invoice.date between date('".$year.'-'.$month."-01') and last_day(date('".$year.'-'.$month."-01'))
                            end
                        )
                    and
                        ar_invoice.name not like '%Installation%'
                )) as total_not_created"),
            )
            ->having('total_not_created', '>', 0);

        foreach ($customers_query->cursor() as $customer) {
            CustomerModel::find($customer->id)->invoice_scheme_pays->each(function ($scheme) {
                static::createOrUpdate($scheme, true);
            });
        }
    }

    public static function createZipReceiptDaily()
    {
        $log = applog('erp, ar_invoice__fac, create_zip_receipt_daily');
        $log->save('debug');

        if (! FacadesApp::environment('production')) {
            return;
        }

        $branches = Branch::with('invoices')->get();
        $branches->map(function ($branch) use ($log) {
            $log->save($branch->name);

            foreach (MonthYear::getMonthLang() as $month_index => $month_name) {
                $log->save($month_name);

                $storage = Storage::disk(config('filesystems.primary_disk'));
                $bucket = ZipStreamFac::set(config('filesystems.primary_disk'));

                // subsidy_only
                $file_name = $month_name.'_'.'Subsidy_Only'.'_'.$branch->name.'.zip';
                $zip = ZipStream::create($file_name);

                $branch->invoices()
                    ->whereMonth('date', $month_index + 1)
                    ->whereYear('date', Carbon::now()->year)
                    ->where('name', 'like', '%Subsidy%')
                    ->each(function ($invoice) use ($bucket, $storage, $zip) {
                        $file_name = str_replace('/', '_', $invoice->number).'.pdf';
                        $path = 'invoice_receipt/'.$file_name;

                        if (! $storage->exists($path)) {
                            dispatch(new ArInvoiceCreatePdfReceipt($invoice->id));

                            return true;
                        }

                        $zip->add('s3://'.$bucket.'/'.$path);
                    });

                $zip->saveTo('s3://'.$bucket.'/invoice_receipt_zip');

                // non_subsidy_only
                $file_name = $month_name.'_'.'Non_Subsidy_Only'.'_'.$branch->name.'.zip';
                $zip = ZipStream::create($file_name);

                $branch->invoices()
                    ->whereMonth('date', $month_index + 1)
                    ->whereYear('date', Carbon::now()->year)
                    ->where('name', 'not like', '%Subsidy%')
                    ->each(function ($invoice) use ($bucket, $storage, $zip) {
                        $file_name = str_replace('/', '_', $invoice->number).'.pdf';
                        $path = 'invoice_receipt/'.$file_name;

                        if (! $storage->exists($path)) {
                            dispatch(new ArInvoiceCreatePdfReceipt($invoice->id));

                            return true;
                        }

                        $zip->add('s3://'.$bucket.'/'.$path);
                    });

                $zip->saveTo('s3://'.$bucket.'/invoice_receipt_zip');
            }
        });

        // set visibility
        $storage = Storage::disk(config('filesystems.primary_disk'));

        foreach ($storage->files('invoice_receipt_zip') as $file) {
            $storage->setVisibility($file, 'public');
        }
    }

    public static function sendEmailDaily()
    {
        $log = applog('erp, ar_invoice__fac, send_email_daily');
        $log->save('debug');

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
                'product.price',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $customer_product_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer_product.auto_sent_invoice_via_email',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'product.name as product_name',
                'product.payment_scheme_name',
                'product.price as product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            });

        $invoice_customer_product_query = DB::table('ar_invoice_customer_product')
            ->select(
                'ar_invoice_customer_product.ar_invoice_customer_id',
                'customer_product.auto_sent_invoice_via_email',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'customer_product.product_name',
                'customer_product.payment_scheme_name',
                'customer_product.product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($customer_product_query, 'customer_product', function ($join) {
                $join->on('customer_product.id', '=', 'ar_invoice_customer_product.customer_product_id');
            });

        $invoice_customer_query = DB::table('ar_invoice_customer')
            ->select(
                'ar_invoice_customer.ar_invoice_id',
                'ar_invoice_customer_product.auto_sent_invoice_via_email',
                'ar_invoice_customer_product.billing_date',
                'ar_invoice_customer_product.billing_start_date',
                'ar_invoice_customer_product.billing_end_date',
                'ar_invoice_customer_product.product_name',
                'ar_invoice_customer_product.payment_scheme_name',
                'ar_invoice_customer_product.product_price',
                'ar_invoice_customer_product.adjusted_price',
                'ar_invoice_customer_product.special_price',
            )
            ->leftJoinSub($invoice_customer_product_query, 'ar_invoice_customer_product', function ($join) {
                $join->on('ar_invoice_customer.id', '=', 'ar_invoice_customer_product.ar_invoice_customer_id');
            });

        $invoices = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                'ar_invoice.payer_name',
                'ar_invoice.payer_cid',
                'ar_invoice.number',
                DB::raw("(
                    case when
                        ar_invoice_customer.payment_scheme_name = 'Monthly'
                    then
                        case when
                            ar_invoice_customer.billing_start_date is not null
                        then
                            case when
                                ar_invoice_customer.billing_end_date is not null
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_start_date and
                                    curdate() <= ar_invoice_customer.billing_end_date
                                )
                            else
                                (curdate() >= ar_invoice_customer.billing_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            ar_invoice_customer.billing_date is not null
                        then
                            case when
                                ar_invoice_customer.product_name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_date and
                                    curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 4 month))
                                )
                            else
                                case when
                                    ar_invoice_customer.product_name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= ar_invoice_customer.billing_date and
                                        curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 8 month))
                                    )
                                else
                                    (ar_invoice_customer.billing_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as active"),
                DB::raw('(
                    case when
                        (
                            select
                                count(customer_email.id)
                            from
                                customer_email
                            where
                                customer_email.customer_id = ar_invoice.payer
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as has_email'),
                DB::raw('(
                    case when
                        (
                            case when
                                ar_invoice_customer.adjusted_price
                            then
                                ar_invoice_customer.special_price
                            else
                                ar_invoice_customer.product_price
                            end
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as price_is_valid'),
            )
            ->leftJoinSub($invoice_customer_query, 'ar_invoice_customer', function ($join) {
                $join->on('ar_invoice.id', '=', 'ar_invoice_customer.ar_invoice_id');
            })
            ->leftJoin('customer', 'customer.id', '=', 'ar_invoice.payer')
            ->where('ar_invoice.paid', false)
            ->where('ar_invoice.email_sent', false)
            ->where(function ($query) {
                $query->whereNull('ar_invoice.reminder_email_sent_at');
                $query->orWhere(function ($query) {
                    $query->whereRaw('date(ar_invoice.reminder_email_sent_at) != curdate()');
                });
            })
            ->where('ar_invoice_customer.auto_sent_invoice_via_email', true)
            ->whereMonth('ar_invoice.date', DB::raw('month(curdate())'))
            ->whereYear('ar_invoice.date', DB::raw('year(curdate())'))
            ->whereRaw('curdate() >= ar_invoice.date')
            ->where('ar_invoice.name', 'not like', '%Installation%')
            ->having('has_email', true)
            ->having('active', true)
            ->having('price_is_valid', true)
            ->get();

        $invoices->each(function ($invoice) use ($log) {
            $log->new()->properties($invoice)->save('invoice data');

            if (! ArInvoiceModel::where('id', $invoice->id)->exists()) {
                return true;
            }

            if (static::sendEmail(ArInvoiceModel::find($invoice->id), true)) {
                // log
                $invoice_log = ArInvoiceLog::create([
                    'title' => 'send email',
                    'ar_invoice_id' => $invoice->id,
                ]);
                $log->new()->properties($invoice_log->id)->save('ar invoice log');
            }
        });
    }

    public static function sendWhatsappDaily()
    {
        $log = applog('erp, ar_invoice__fac, send_whatsapp_daily');
        $log->save('debug');

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
                'product.price',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $customer_product_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer_product.auto_sent_invoice_via_whatsapp',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'product.name as product_name',
                'product.payment_scheme_name',
                'product.price as product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            });

        $invoice_customer_product_query = DB::table('ar_invoice_customer_product')
            ->select(
                'ar_invoice_customer_product.ar_invoice_customer_id',
                'customer_product.auto_sent_invoice_via_whatsapp',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'customer_product.product_name',
                'customer_product.payment_scheme_name',
                'customer_product.product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($customer_product_query, 'customer_product', function ($join) {
                $join->on('customer_product.id', '=', 'ar_invoice_customer_product.customer_product_id');
            });

        $invoice_customer_query = DB::table('ar_invoice_customer')
            ->select(
                'ar_invoice_customer.ar_invoice_id',
                'ar_invoice_customer_product.auto_sent_invoice_via_whatsapp',
                'ar_invoice_customer_product.billing_date',
                'ar_invoice_customer_product.billing_start_date',
                'ar_invoice_customer_product.billing_end_date',
                'ar_invoice_customer_product.product_name',
                'ar_invoice_customer_product.payment_scheme_name',
                'ar_invoice_customer_product.product_price',
                'ar_invoice_customer_product.adjusted_price',
                'ar_invoice_customer_product.special_price',
            )
            ->leftJoinSub($invoice_customer_product_query, 'ar_invoice_customer_product', function ($join) {
                $join->on('ar_invoice_customer.id', '=', 'ar_invoice_customer_product.ar_invoice_customer_id');
            });

        $invoices = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                'ar_invoice.payer_name',
                'ar_invoice.payer_cid',
                'ar_invoice.number',
                DB::raw("(
                    case when
                        ar_invoice_customer.payment_scheme_name = 'Monthly'
                    then
                        case when
                            ar_invoice_customer.billing_start_date is not null
                        then
                            case when
                                ar_invoice_customer.billing_end_date is not null
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_start_date and
                                    curdate() <= ar_invoice_customer.billing_end_date
                                )
                            else
                                (curdate() >= ar_invoice_customer.billing_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            ar_invoice_customer.billing_date is not null
                        then
                            case when
                                ar_invoice_customer.product_name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_date and
                                    curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 4 month))
                                )
                            else
                                case when
                                    ar_invoice_customer.product_name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= ar_invoice_customer.billing_date and
                                        curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 8 month))
                                    )
                                else
                                    (ar_invoice_customer.billing_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as active"),
                DB::raw('(
                    case when
                        (
                            select
                                count(customer_phone_number.id)
                            from
                                customer_phone_number
                            where
                                customer_phone_number.customer_id = ar_invoice.payer
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as has_phone_number'),
                DB::raw('(
                    case when
                        (
                            case when
                                ar_invoice_customer.adjusted_price
                            then
                                ar_invoice_customer.special_price
                            else
                                ar_invoice_customer.product_price
                            end
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as price_is_valid'),
            )
            ->leftJoinSub($invoice_customer_query, 'ar_invoice_customer', function ($join) {
                $join->on('ar_invoice.id', '=', 'ar_invoice_customer.ar_invoice_id');
            })
            ->leftJoin('customer', 'customer.id', '=', 'ar_invoice.payer')
            ->where('ar_invoice.paid', false)
            ->where('ar_invoice.whatsapp_sent', false)
            ->where(function ($query) {
                $query->whereNull('ar_invoice.reminder_whatsapp_sent_at');
                $query->orWhere(function ($query) {
                    $query->whereRaw('date(ar_invoice.reminder_whatsapp_sent_at) != curdate()');
                });
            })
            ->where('ar_invoice_customer.auto_sent_invoice_via_whatsapp', true)
            ->whereMonth('ar_invoice.date', DB::raw('month(curdate())'))
            ->whereYear('ar_invoice.date', DB::raw('year(curdate())'))
            ->whereRaw('curdate() >= ar_invoice.date')
            ->where('ar_invoice.name', 'not like', '%Installation%')
            ->having('has_phone_number', true)
            ->having('active', true)
            ->having('price_is_valid', true)
            ->get();

        $invoices->each(function ($invoice) use ($log) {
            $log->new()->properties($invoice)->save('invoice data');
            if (static::sendWhatsapp(ArInvoiceModel::find($invoice->id), true)) {
                // log
                $invoice_log = ArInvoiceLog::create([
                    'title' => 'send whatsapp',
                    'ar_invoice_id' => $invoice->id,
                ]);
                $log->new()->properties($invoice_log->id)->save('ar invoice log');
            }
        });
    }

    public static function sendEmailReminderDaily()
    {
        $log = applog('erp, ar_invoice__fac, send_email_reminder_daily');
        $log->save('debug');

        // untuk invoice yang belum dibayar
        // untuk invoice yang belum dikirim invoice reminder hari ini
        // untuk invoice yang sudah dikirim
        // untuk invoice yang belum dikirim invoice hari ini, mencegah duplikasi notifikasi
        // untuk customer yang auto reminder-nya on
        // untuk invoice yang date-nya bulan ini
        // untuk invoice yang sudah lima hari dari tanggal terbit
        // untuk customer yang mempunyai email
        // untuk invoice selain instalasi
        // untuk customer yang aktif

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
                'product.price',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $customer_product_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer_product.auto_sent_invoice_reminder_via_email',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'product.name as product_name',
                'product.payment_scheme_name',
                'product.price as product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            });

        $invoice_customer_product_query = DB::table('ar_invoice_customer_product')
            ->select(
                'ar_invoice_customer_product.ar_invoice_customer_id',
                'customer_product.auto_sent_invoice_reminder_via_email',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'customer_product.product_name',
                'customer_product.payment_scheme_name',
                'customer_product.product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($customer_product_query, 'customer_product', function ($join) {
                $join->on('customer_product.id', '=', 'ar_invoice_customer_product.customer_product_id');
            });

        $invoice_customer_query = DB::table('ar_invoice_customer')
            ->select(
                'ar_invoice_customer.ar_invoice_id',
                'ar_invoice_customer_product.auto_sent_invoice_reminder_via_email',
                'ar_invoice_customer_product.billing_date',
                'ar_invoice_customer_product.billing_start_date',
                'ar_invoice_customer_product.billing_end_date',
                'ar_invoice_customer_product.product_name',
                'ar_invoice_customer_product.payment_scheme_name',
                'ar_invoice_customer_product.product_price',
                'ar_invoice_customer_product.adjusted_price',
                'ar_invoice_customer_product.special_price',
            )
            ->leftJoinSub($invoice_customer_product_query, 'ar_invoice_customer_product', function ($join) {
                $join->on('ar_invoice_customer.id', '=', 'ar_invoice_customer_product.ar_invoice_customer_id');
            });

        $invoices = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                'ar_invoice.payer_name',
                'ar_invoice.payer_cid',
                'ar_invoice.number',
                DB::raw("(
                    case when
                        ar_invoice_customer.payment_scheme_name = 'Monthly'
                    then
                        case when
                            ar_invoice_customer.billing_start_date is not null
                        then
                            case when
                                ar_invoice_customer.billing_end_date is not null
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_start_date and
                                    curdate() <= ar_invoice_customer.billing_end_date
                                )
                            else
                                (curdate() >= ar_invoice_customer.billing_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            ar_invoice_customer.billing_date is not null
                        then
                            case when
                                ar_invoice_customer.product_name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_date and
                                    curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 4 month))
                                )
                            else
                                case when
                                    ar_invoice_customer.product_name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= ar_invoice_customer.billing_date and
                                        curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 8 month))
                                    )
                                else
                                    (ar_invoice_customer.billing_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as active"),
                DB::raw('(
                    case when
                        (
                            select
                                count(customer_email.id)
                            from
                                customer_email
                            where
                                customer_email.customer_id = ar_invoice.payer
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as has_email'),
                DB::raw('(
                    case when
                        (
                            case when
                                ar_invoice_customer.adjusted_price
                            then
                                ar_invoice_customer.special_price
                            else
                                ar_invoice_customer.product_price
                            end
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as price_is_valid'),
            )
            ->leftJoinSub($invoice_customer_query, 'ar_invoice_customer', function ($join) {
                $join->on('ar_invoice.id', '=', 'ar_invoice_customer.ar_invoice_id');
            })
            ->leftJoin('customer', 'customer.id', '=', 'ar_invoice.payer')
            ->where('ar_invoice.paid', false)
            ->where(function ($query) {
                $query->whereNull('ar_invoice.reminder_email_sent_at');
                $query->orWhere(function ($query) {
                    $query->whereRaw('date(ar_invoice.reminder_email_sent_at) != curdate()');
                });
            })
            ->where('ar_invoice.email_sent', true)
            ->where(function ($query) {
                $query->whereNull('ar_invoice.email_sent_at');
                $query->orWhere(function ($query) {
                    $query->whereRaw('date(ar_invoice.email_sent_at) != curdate()');
                });
            })
            ->where('ar_invoice_customer.auto_sent_invoice_reminder_via_email', true)
            ->whereMonth('ar_invoice.date', DB::raw('month(curdate())'))
            ->whereYear('ar_invoice.date', DB::raw('year(curdate())'))
            ->where(function ($query) {
                $query->whereRaw('curdate() = date_sub(ar_invoice.due_date, interval 1 day)');
                $query->orWhereRaw('curdate() = date_sub(ar_invoice.due_date, interval 2 day)');
                $query->orWhereRaw('curdate() = date_sub(ar_invoice.due_date, interval 3 day)');
            })
            ->where('ar_invoice.name', 'not like', '%Installation%')
            ->having('has_email', true)
            ->having('active', true)
            ->having('price_is_valid', true)
            ->get();

        $invoices->each(function ($invoice) use ($log) {
            $log->new()->properties($invoice)->save('invoice data');
            if (static::sendReminderEmail(ArInvoiceModel::find($invoice->id), true)) {
                // log
                $invoice_log = ArInvoiceLog::create([
                    'title' => 'send reminder email',
                    'ar_invoice_id' => $invoice->id,
                ]);
                $log->new()->properties($invoice_log->id)->save('ar invoice log');
            }
        });
    }

    public static function installationSendWhatsappDaily()
    {
        $log = applog('erp, ar_invoice__fac, installation_send_whatsapp_daily');
        $log->save('debug');

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.price',
            );

        $customer_product_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer_product.auto_sent_invoice_via_whatsapp',
                'product.price as product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            });

        $customer_product_additional_query = DB::table('customer_product_additional')
            ->select(
                'customer_product_additional.id',
                'customer_product.auto_sent_invoice_via_whatsapp',
                'customer_product.product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($customer_product_query, 'customer_product', function ($join) {
                $join->on('customer_product.id', '=', 'customer_product_additional.customer_product_id');
            });

        $invoice_customer_product_additional_query = DB::table('ar_invoice_customer_product_additional')
            ->select(
                'ar_invoice_customer_product_additional.ar_invoice_customer_id',
                'customer_product_additional.auto_sent_invoice_via_whatsapp',
                'customer_product_additional.product_price',
                'customer_product_additional.adjusted_price',
                'customer_product_additional.special_price',
            )
            ->leftJoinSub($customer_product_additional_query, 'customer_product_additional', function ($join) {
                $join->on('customer_product_additional.id', '=', 'ar_invoice_customer_product_additional.customer_product_additional_id');
            });

        $invoice_customer_query = DB::table('ar_invoice_customer')
            ->select(
                'ar_invoice_customer.ar_invoice_id',
                'ar_invoice_customer_product_additional.auto_sent_invoice_via_whatsapp',
                'ar_invoice_customer_product_additional.product_price',
                'ar_invoice_customer_product_additional.adjusted_price',
                'ar_invoice_customer_product_additional.special_price',
            )
            ->leftJoinSub($invoice_customer_product_additional_query, 'ar_invoice_customer_product_additional', function ($join) {
                $join->on('ar_invoice_customer.id', '=', 'ar_invoice_customer_product_additional.ar_invoice_customer_id');
            });

        $invoices = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                'ar_invoice.payer_name',
                'ar_invoice.payer_cid',
                'ar_invoice.number',
                DB::raw('(
                    case when
                        (
                            select
                                count(customer_phone_number.id)
                            from
                                customer_phone_number
                            where
                                customer_phone_number.customer_id = ar_invoice.payer
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as has_phone_number'),
                DB::raw('(
                    case when
                        (
                            case when
                                ar_invoice_customer.adjusted_price
                            then
                                ar_invoice_customer.special_price
                            else
                                ar_invoice_customer.product_price
                            end
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as price_is_valid'),
            )
            ->leftJoinSub($invoice_customer_query, 'ar_invoice_customer', function ($join) {
                $join->on('ar_invoice.id', '=', 'ar_invoice_customer.ar_invoice_id');
            })
            ->leftJoin('customer', 'customer.id', '=', 'ar_invoice.payer')
            ->where('ar_invoice.paid', false)
            ->where('ar_invoice.whatsapp_sent', false)
            ->where(function ($query) {
                $query->whereNull('ar_invoice.reminder_whatsapp_sent_at');
                $query->orWhere(function ($query) {
                    $query->whereRaw('date(ar_invoice.reminder_whatsapp_sent_at) != curdate()');
                });
            })
            ->where('ar_invoice_customer.auto_sent_invoice_via_whatsapp', true)
            ->whereMonth('ar_invoice.date', DB::raw('month(curdate())'))
            ->whereYear('ar_invoice.date', DB::raw('year(curdate())'))
            ->whereRaw('curdate() >= ar_invoice.date')
            ->where('ar_invoice.name', 'like', '%Installation%')
            ->where('ar_invoice.hybrid', true)
            ->having('price_is_valid', true)
            ->having('has_phone_number', true)
            ->get();

        $invoices->each(function ($invoice) use ($log) {
            $log->new()->properties($invoice)->save('invoice data');
            if (static::sendWhatsapp(ArInvoiceModel::find($invoice->id), true)) {
                // log
                $invoice_log = ArInvoiceLog::create([
                    'title' => 'send whatsapp',
                    'ar_invoice_id' => $invoice->id,
                ]);
                $log->new()->properties($invoice_log->id)->save('ar invoice log');
            }
        });
    }

    public static function sendWhatsappReminderDaily()
    {
        $log = applog('erp, ar_invoice__fac, send_whatsapp_reminder_daily');
        $log->save('debug');

        // untuk invoice yang belum dibayar
        // untuk invoice yang belum dikirim invoice reminder hari ini
        // untuk invoice yang sudah dikirim
        // untuk invoice yang belum dikirim invoice hari ini, mencegah duplikasi notifikasi
        // untuk customer yang auto reminder-nya on
        // untuk invoice yang date-nya bulan ini
        // untuk invoice yang sudah lima hari dari tanggal terbit
        // untuk customer yang mempunyai phone number
        // untuk invoice selain instalasi
        // untuk customer yang aktif

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
                'product.price',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $customer_product_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer_product.auto_sent_invoice_reminder_via_whatsapp',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'product.name as product_name',
                'product.payment_scheme_name',
                'product.price as product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            });

        $invoice_customer_product_query = DB::table('ar_invoice_customer_product')
            ->select(
                'ar_invoice_customer_product.ar_invoice_customer_id',
                'customer_product.auto_sent_invoice_reminder_via_whatsapp',
                'customer_product.billing_date',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'customer_product.product_name',
                'customer_product.payment_scheme_name',
                'customer_product.product_price',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->leftJoinSub($customer_product_query, 'customer_product', function ($join) {
                $join->on('customer_product.id', '=', 'ar_invoice_customer_product.customer_product_id');
            });

        $invoice_customer_query = DB::table('ar_invoice_customer')
            ->select(
                'ar_invoice_customer.ar_invoice_id',
                'ar_invoice_customer_product.auto_sent_invoice_reminder_via_whatsapp',
                'ar_invoice_customer_product.billing_date',
                'ar_invoice_customer_product.billing_start_date',
                'ar_invoice_customer_product.billing_end_date',
                'ar_invoice_customer_product.product_name',
                'ar_invoice_customer_product.payment_scheme_name',
                'ar_invoice_customer_product.product_price',
                'ar_invoice_customer_product.adjusted_price',
                'ar_invoice_customer_product.special_price',
            )
            ->leftJoinSub($invoice_customer_product_query, 'ar_invoice_customer_product', function ($join) {
                $join->on('ar_invoice_customer.id', '=', 'ar_invoice_customer_product.ar_invoice_customer_id');
            });

        $invoices = DB::table('ar_invoice')
            ->select(
                'ar_invoice.id',
                'ar_invoice.payer_name',
                'ar_invoice.payer_cid',
                'ar_invoice.number',
                DB::raw("(
                    case when
                        ar_invoice_customer.payment_scheme_name = 'Monthly'
                    then
                        case when
                            ar_invoice_customer.billing_start_date is not null
                        then
                            case when
                                ar_invoice_customer.billing_end_date is not null
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_start_date and
                                    curdate() <= ar_invoice_customer.billing_end_date
                                )
                            else
                                (curdate() >= ar_invoice_customer.billing_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            ar_invoice_customer.billing_date is not null
                        then
                            case when
                                ar_invoice_customer.product_name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= ar_invoice_customer.billing_date and
                                    curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 4 month))
                                )
                            else
                                case when
                                    ar_invoice_customer.product_name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= ar_invoice_customer.billing_date and
                                        curdate() <= last_day(date_add(ar_invoice_customer.billing_date, interval 8 month))
                                    )
                                else
                                    (ar_invoice_customer.billing_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as active"),
                DB::raw('(
                    case when
                        (
                            select
                                count(customer_phone_number.id)
                            from
                                customer_phone_number
                            where
                                customer_phone_number.customer_id = ar_invoice.payer
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as has_phone_number'),
                DB::raw('(
                    case when
                        (
                            case when
                                ar_invoice_customer.adjusted_price
                            then
                                ar_invoice_customer.special_price
                            else
                                ar_invoice_customer.product_price
                            end
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as price_is_valid'),
            )
            ->leftJoinSub($invoice_customer_query, 'ar_invoice_customer', function ($join) {
                $join->on('ar_invoice.id', '=', 'ar_invoice_customer.ar_invoice_id');
            })
            ->leftJoin('customer', 'customer.id', '=', 'ar_invoice.payer')
            ->where('ar_invoice.paid', false)
            ->where(function ($query) {
                $query->whereNull('ar_invoice.reminder_whatsapp_sent_at');
                $query->orWhere(function ($query) {
                    $query->whereRaw('date(ar_invoice.reminder_whatsapp_sent_at) != curdate()');
                });
            })
            ->where('ar_invoice.whatsapp_sent', true)
            ->where(function ($query) {
                $query->whereNull('ar_invoice.whatsapp_sent_at');
                $query->orWhere(function ($query) {
                    $query->whereRaw('date(ar_invoice.whatsapp_sent_at) != curdate()');
                });
            })
            ->where('ar_invoice_customer.auto_sent_invoice_reminder_via_whatsapp', true)
            ->whereMonth('ar_invoice.date', DB::raw('month(curdate())'))
            ->whereYear('ar_invoice.date', DB::raw('year(curdate())'))
            ->where(function ($query) {
                $query->whereRaw('curdate() = date_sub(ar_invoice.due_date, interval 1 day)');
                $query->orWhereRaw('curdate() = date_sub(ar_invoice.due_date, interval 2 day)');
                $query->orWhereRaw('curdate() = date_sub(ar_invoice.due_date, interval 3 day)');
            })
            ->where('ar_invoice.name', 'not like', '%Installation%')
            ->having('has_phone_number', true)
            ->having('active', true)
            ->having('price_is_valid', true)
            ->get();

        $invoices->each(function ($invoice) use ($log) {
            $log->new()->properties($invoice)->save('invoice data');
            if (static::sendReminderWhatsapp(ArInvoiceModel::find($invoice->id), true)) {
                // log
                $invoice_log = ArInvoiceLog::create([
                    'title' => 'send reminder whatsapp',
                    'ar_invoice_id' => $invoice->id,
                ]);
                $log->new()->properties($invoice_log->id)->save('ar invoice log');
            }
        });
    }

    public static function enterpriseCalculate(ArInvoiceModel $invoice_obj)
    {
        $log = applog('erp, ar_invoice__fac, enterprise_calculate');
        $log->save('debug');

        $discount = 0;
        $discount_usd = 0;
        $discount_sgd = 0;

        $tax_base = 0;
        $tax_base_usd = 0;
        $tax_base_sgd = 0;

        $tax_base_bandwidth = 0;
        $tax_base_data_center = 0;
        $tax_base_instalasi = 0;
        $tax_base_manage_service = 0;
        $tax_base_lain_lain = 0;
        $tax_base_aplikasi = 0;

        $tax = 0;
        $tax_usd = 0;
        $tax_sgd = 0;

        $total = 0;
        $total_usd = 0;
        $total_sgd = 0;

        $invoice_customer = $invoice_obj->invoice_customers->first();

        // product
        $invoice_customer_product = $invoice_customer->invoice_customer_products->first();

        $tax_base += $invoice_customer_product->total;
        $tax_base_usd += $invoice_customer_product->total_usd;
        $tax_base_sgd += $invoice_customer_product->total_sgd;

        if ($invoice_customer_product->item_category) {
            switch ($invoice_customer_product->item_category->name) {
                case 'Bandwidth':
                    $tax_base_bandwidth += $invoice_customer_product->total;
                    break;

                case 'Data Center':
                    $tax_base_data_center += $invoice_customer_product->total;
                    break;

                case 'Instalasi':
                    $tax_base_instalasi += $invoice_customer_product->total;
                    break;

                case 'Manage Service':
                    $tax_base_manage_service += $invoice_customer_product->total;
                    break;

                case 'Lain-Lain':
                    $tax_base_lain_lain += $invoice_customer_product->total;
                    break;

                case 'Aplikasi':
                    $tax_base_aplikasi += $invoice_customer_product->total;
                    break;
            }
        }

        // additional
        $invoice_customer_product->invoice_customer_product_additionals->each(function ($invoice_customer_product_additional) use (
            &$tax_base,
            &$tax_base_usd,
            &$tax_base_sgd,
            &$tax_base_bandwidth,
            &$tax_base_data_center,
            &$tax_base_instalasi,
            &$tax_base_manage_service,
            &$tax_base_lain_lain,
            &$tax_base_aplikasi
        ) {
            $tax_base += $invoice_customer_product_additional->total;
            $tax_base_usd += $invoice_customer_product_additional->total_usd;
            $tax_base_sgd += $invoice_customer_product_additional->total_sgd;

            if ($invoice_customer_product_additional->item_category) {
                switch ($invoice_customer_product_additional->item_category->name) {
                    case 'Bandwidth':
                        $tax_base_bandwidth += $invoice_customer_product_additional->total;
                        break;

                    case 'Data Center':
                        $tax_base_data_center += $invoice_customer_product_additional->total;
                        break;

                    case 'Instalasi':
                        $tax_base_instalasi += $invoice_customer_product_additional->total;
                        break;

                    case 'Manage Service':
                        $tax_base_manage_service += $invoice_customer_product_additional->total;
                        break;

                    case 'Lain-Lain':
                        $tax_base_lain_lain += $invoice_customer_product_additional->total;
                        break;

                    case 'Aplikasi':
                        $tax_base_aplikasi += $invoice_customer_product_additional->total;
                        break;
                }
            }
        });

        // discount
        $invoice_customer_product->invoice_customer_product_discounts->each(function ($invoice_customer_product_discount) use (
            &$tax_base,
            &$tax_base_usd,
            &$tax_base_sgd,
            &$discount,
            &$discount_usd,
            &$discount_sgd
        ) {
            $discount += $invoice_customer_product_discount->total;
            $discount_usd += $invoice_customer_product_discount->total_usd;
            $discount_sgd += $invoice_customer_product_discount->total_sgd;

            $tax_base -= $invoice_customer_product_discount->total;
            $tax_base_usd -= $invoice_customer_product_discount->total_usd;
            $tax_base_sgd -= $invoice_customer_product_discount->total_sgd;
        });

        $tax_rate = 10;
        if ($invoice_obj->date->gte(Carbon::create(2022, 4, 1, 0))) {
            $tax_rate = 11;
        }
        if ($invoice_obj->tax_rate) {
            $tax_rate = $invoice_obj->tax_rate;
        }

        $tax_rounding_func = function ($tax_base, $tax_rate, $rounding) {
            $tax = 0;

            switch ($rounding) {
                case 'up':
                    $tax = ceil($tax_base * $tax_rate / 100);
                    break;

                case 'down':
                default:
                    $tax = floor($tax_base * $tax_rate / 100);
                    break;
            }

            return $tax;
        };

        $tax = $tax_rounding_func($tax_base, $tax_rate, $invoice_obj->tax_rounding);
        $tax_usd = $tax_rounding_func($tax_base_usd, $tax_rate, $invoice_obj->tax_rounding);
        $tax_sgd = $tax_rounding_func($tax_base_sgd, $tax_rate, $invoice_obj->tax_rounding);

        if (! $invoice_obj->is_tax) {
            $tax = 0;
            $tax_usd = 0;
            $tax_sgd = 0;
        }

        $total = $tax + $tax_base;
        $total_usd = $tax_usd + $tax_base_usd;
        $total_sgd = $tax_sgd + $tax_base_sgd;

        $invoice_obj->discount = $discount;
        $invoice_obj->tax_base = $tax_base;
        $invoice_obj->tax = $tax;
        $invoice_obj->total = $total;

        $invoice_obj->tax_base_bandwidth = $tax_base_bandwidth;
        $invoice_obj->tax_base_data_center = $tax_base_data_center;
        $invoice_obj->tax_base_instalasi = $tax_base_instalasi;
        $invoice_obj->tax_base_manage_service = $tax_base_manage_service;
        $invoice_obj->tax_base_lain_lain = $tax_base_lain_lain;
        $invoice_obj->tax_base_aplikasi = $tax_base_aplikasi;

        $invoice_obj->discount_usd = $discount_usd;
        $invoice_obj->discount_sgd = $discount_sgd;

        $invoice_obj->tax_base_usd = $tax_base_usd;
        $invoice_obj->tax_base_sgd = $tax_base_sgd;

        $invoice_obj->tax_usd = $tax_usd;
        $invoice_obj->tax_sgd = $tax_sgd;

        $invoice_obj->total_usd = $total_usd;
        $invoice_obj->total_sgd = $total_sgd;

        $invoice_obj->save();
    }

    public static function enterpriseCreatePdf(ArInvoiceModel $invoice, $disk = null)
    {
        $log = applog('erp, ar_invoice__fac, enterprise_create_pdf');
        $log->save('debug');

        $invoice->load([
            'invoice_customers',

            'invoice_customers.invoice_customer_products',
            'invoice_customers.invoice_customer_products.customer_product',
            'invoice_customers.invoice_customer_products.customer_product.product',
            'invoice_customers.invoice_customer_products.customer_product.product.payment_scheme',

            'invoice_customers.invoice_customer_products.invoice_customer_product_additionals',
            'invoice_customers.invoice_customer_product_additionals',

            'invoice_billings',

            'brand',
            'brand.type',
        ]);

        $invoice->formatted_date = $invoice->date ? $invoice->date->translatedFormat('d F Y') : '-';
        $invoice->formatted_due_date = $invoice->due_date ? $invoice->due_date->translatedFormat('d F Y') : '-';

        $invoice->formatted_start_period = $invoice->period_start_date ? $invoice->period_start_date->translatedFormat('d F Y') : '-';
        $invoice->formatted_end_period = $invoice->period_end_date ? $invoice->period_end_date->translatedFormat('d F Y') : '-';

        $invoice->invoice_customers->each(function ($invoice_customer) use (&$invoice) {
            $invoice_customer->invoice_customer_products->each(function ($invoice_customer_product) use (&$invoice) {
                $customer_product = $invoice_customer_product->customer_product;

                if ($customer_product) {
                    $product = $customer_product->product;

                    if ($product) {
                        $payment_scheme = $product->payment_scheme;

                        if ($payment_scheme && $payment_scheme->name === 'Monthly') {
                            if ($invoice_customer_product->billing_start_date && $invoice_customer_product->billing_end_date) {
                                $invoice->formatted_start_period = $invoice_customer_product->billing_start_date->translatedFormat('d F Y');
                                $invoice->formatted_end_period = $invoice_customer_product->billing_end_date->translatedFormat('d F Y');
                            }
                        }
                    }
                }
            });
        });

        $invoice->total_in_words = Calculate::denominator($invoice->total);

        $invoice->brand_type_name = null;
        if ($invoice->brand) {
            if ($invoice->brand->type) {
                $invoice->brand_type_name = $invoice->brand->type->name;
            }
        }

        $payment_link = config('app.client_domain').'/pay'.'/'.$invoice->uuid;
        $invoice_link = config('app.client_domain').'/invoice'.'/'.$invoice->uuid;

        $invoice->qr_code = (new PngWriter())->write(EndroidQrCode::create($invoice->brand_type_name === 'Retail Internet Service' ? $payment_link : $invoice_link)->setSize(128)->setMargin(0))->getDataUri();
        $invoice->payment_link = $invoice->brand_type_name === 'Retail Internet Service' ? $payment_link : null;

        $data['invoice'] = $invoice;

        $pdf = (new PdfWrapper())->loadView('pdf.ar_invoice_enterprise_internet_service.doc', $data, [], [
            'format' => 'Legal',
            'title' => 'Invoice',
            'creator' => $invoice['brand_name'],
        ]);

        $file_path = 'invoice/'.str_replace('/', '_', $invoice['number']).'.pdf';

        if (! $disk) {
            $disk = config('filesystems.primary_disk');
        }

        $storage = Storage::disk($disk);
        if ($storage->exists($file_path)) {
            $storage->delete($file_path);
        }
        $storage->put($file_path, $pdf->output(), 'public');
    }

    public static function enterpriseGenerate(
        $month,
        $year,
        $branch_id,
        $chart_of_account_title_id
    ) {
        $log = applog('erp, ar_invoice__fac, enterprise_generate');
        $log->save('debug');

        $brand_type = ProductBrandType::where('name', 'Enterprise Internet Service')->first();
        $brand = ProductBrand::where('type_id', $brand_type->id)->first();

        foreach (CustomerModel::where('brand_id', $brand->id)
            ->where('branch_id', $branch_id)
            ->cursor() as $customer) {
            static::enterpriseGenerateSigleCustomer(
                $customer,
                $month,
                $year,
                $chart_of_account_title_id
            );
        }
    }

    public static function enterpriseGenerateSigleCustomer(
        CustomerModel $customer,
        $month,
        $year,
        $chart_of_account_title_id
    ) {
        $log = applog('erp, ar_invoice__fac, enterprise_generate_single_customer');
        $log->save('debug');

        $customer->load('customer_products');
        $customer->customer_products->each(function ($customer_product) use (
            $year,
            $month,
            $chart_of_account_title_id
        ) {
            if (! $customer_product->active) {
                return true;
            }
            if (! $customer_product->enterprise_billing_date) {
                return true;
            }
            if (! $customer_product->billing_cycle) {
                return true;
            }
            if (! $customer_product->billing_time) {
                return true;
            }

            $billing_date = $customer_product->enterprise_billing_date->toImmutable();
            $generate_date = Carbon::createFromDate($year, $month, 1)->toImmutable();
            $due_date = $billing_date->addDays($customer_product->billing_time);
            $period_end_date = $billing_date->addMonthsNoOverflow($customer_product->billing_cycle);

            if (! $customer_product->billing_cycle) {
                if (
                    $billing_date->isSameMonth($generate_date) &&
                    $billing_date->isSameYear($generate_date)
                ) {
                    static::enterpriseGenerateSigleService(
                        $customer_product,
                        $chart_of_account_title_id,
                        $billing_date,
                        $due_date,
                        $period_end_date
                    );
                }

                return true;
            }

            do {
                if (
                    $billing_date->isSameMonth($generate_date) &&
                    $billing_date->isSameYear($generate_date)
                ) {
                    static::enterpriseGenerateSigleService(
                        $customer_product,
                        $chart_of_account_title_id,
                        $billing_date,
                        $due_date,
                        $period_end_date
                    );
                }

                $billing_date = $billing_date->addMonthsNoOverflow($customer_product->billing_cycle);
            } while ($billing_date->lt($generate_date->endOfMonth()->addDay()));
        });
    }

    public static function enterpriseGenerateSigleService(
        CustomerProduct $customer_product,
        $chart_of_account_title_id,
        $billing_date,
        $due_date,
        $period_end_date
    ) {
        $log = applog('erp, ar_invoice__fac, enterprise_generate_single_service');
        $log->save('debug');

        $generate = true;

        $customer_product->load([
            'invoice_products',
            'invoice_products.invoice_customer',
            'invoice_products.invoice_customer.invoice',
        ]);

        $customer_product->invoice_products->each(function ($invoice_customer_product) use (
            &$generate,
            $billing_date
        ) {
            if (! $invoice_customer_product->invoice_customer) {
                return true;
            }
            if (! $invoice_customer_product->invoice_customer->invoice) {
                return true;
            }

            if (
                $invoice_customer_product->invoice_customer->invoice->date->isSameMonth($billing_date) &&
                $invoice_customer_product->invoice_customer->invoice->date->isSameYear($billing_date)
            ) {
                $generate = false;
            }
        });

        if ($generate) {
            $chart_of_account_title = ChartOfAccountTitle::find($chart_of_account_title_id);

            $payer = $customer_product->customer;
            $payer->load(['brand', 'brand.type']);

            $discount = 0;
            $discount_usd = 0;
            $discount_sgd = 0;

            $tax_base = 0;
            $tax_base_usd = 0;
            $tax_base_sgd = 0;

            $tax_base_bandwidth = 0;
            $tax_base_data_center = 0;
            $tax_base_instalasi = 0;
            $tax_base_manage_service = 0;
            $tax_base_lain_lain = 0;
            $tax_base_aplikasi = 0;

            $tax = 0;
            $tax_usd = 0;
            $tax_sgd = 0;

            $total = 0;
            $total_usd = 0;
            $total_sgd = 0;

            $invoice_obj = ArInvoiceModel::create([
                'number' => static::enterpriseGenerateNumber($customer_product->customer),
                'date' => $billing_date->toDateString(),
                'due_date' => $due_date->toDateString(),

                'discount' => 0,
                'tax_base' => 0,
                'tax' => 0,
                'total' => 0,

                'payer' => $payer->id,
                'payer_cid' => $payer->cid,
                'payer_name' => $payer->name,

                'branch_id' => $chart_of_account_title->branch_id,
                'regoinal_id' => $chart_of_account_title->branch->regional_id,
                'company_id' => $chart_of_account_title->branch->regional->company_id,

                'brand_id' => $payer->brand->id,
                'brand_name' => $payer->brand->name,

                'receiver_name' => $customer_product->receiver_name,
                'receiver_attention' => $customer_product->receiver_attention,
                'receiver_address' => $customer_product->receiver_address,
                'receiver_postal_code' => null,
                'receiver_phone_number' => $customer_product->receiver_phone_number,
                'receiver_fax' => null,
                'receiver_email' => $customer_product->receiver_email,

                'name' => $customer_product->product_name,
                'chart_of_account_title_id' => $chart_of_account_title->id,

                'product_id' => $customer_product->product_id,
                'product_name' => $customer_product->product_name,

                'memo' => $payer->memo ? true : false,

                'faktur_id' => $customer_product->ar_invoice_faktur_id,
                'qrcode' => $customer_product->qrcode,

                'tax_base_bandwidth' => 0,
                'tax_base_data_center' => 0,
                'tax_base_instalasi' => 0,
                'tax_base_manage_service' => 0,
                'tax_base_lain_lain' => 0,
                'tax_base_aplikasi' => 0,

                'period_start_date' => $billing_date->toDateString(),
                'period_end_date' => $period_end_date->toDateString(),

                'discount_usd' => 0,
                'discount_sgd' => 0,

                'tax_base_usd' => 0,
                'tax_base_sgd' => 0,

                'tax_usd' => 0,
                'tax_sgd' => 0,

                'total_usd' => 0,
                'total_sgd' => 0,

                'payer_category_id' => $payer->category ? $payer->category->id : null,
                'memo_to' => $payer->memo,

                'is_tax' => $customer_product->tax,

                'brand_type_name' => $payer->brand->type->name,

                'billing_npwp_number' => $payer->branch->regional->company->npwp,
                'billing_npwp_on_behalf_of' => $payer->branch->regional->company->name,
                'billing_phone_number' => $payer->branch->billing_phone_number,
                'billing_email' => $payer->branch->billing_email,
                'billing_preparer' => $payer->branch->billing_preparer,
                'billing_approver' => $payer->branch->billing_approver,

                'sid' => $customer_product->sid,
            ]);

            $invoice_customer = $invoice_obj->invoice_customers()->create([
                'customer_id' => $payer->id,
            ]);

            // product
            $invoice_customer_product = $invoice_customer->invoice_customer_products()->create([
                'product_id' => $customer_product->product_id,
                'product_name' => $customer_product->product_name,

                'ar_invoice_item_category_id' => $customer_product->ar_invoice_item_category_id,

                'total' => $customer_product->product_price,
                'total_usd' => $customer_product->product_price_usd,
                'total_sgd' => $customer_product->product_price_sgd,

                'customer_product_id' => $customer_product->id,
            ]);

            $tax_base += $invoice_customer_product->total;
            $tax_base_usd += $invoice_customer_product->total_usd;
            $tax_base_sgd += $invoice_customer_product->total_sgd;

            if ($invoice_customer_product->item_category) {
                switch ($invoice_customer_product->item_category->name) {
                    case 'Bandwidth':
                        $tax_base_bandwidth += $invoice_customer_product->total;
                        break;

                    case 'Data Center':
                        $tax_base_data_center += $invoice_customer_product->total;
                        break;

                    case 'Instalasi':
                        $tax_base_instalasi += $invoice_customer_product->total;
                        break;

                    case 'Manage Service':
                        $tax_base_manage_service += $invoice_customer_product->total;
                        break;

                    case 'Lain-Lain':
                        $tax_base_lain_lain += $invoice_customer_product->total;
                        break;

                    case 'Aplikasi':
                        $tax_base_aplikasi += $invoice_customer_product->total;
                        break;
                }
            }

            // additional
            $customer_product->customer_product_additionals->each(function ($additional) use (
                $invoice_customer_product,
                &$tax_base,
                &$tax_base_usd,
                &$tax_base_sgd,
                &$tax_base_bandwidth,
                &$tax_base_data_center,
                &$tax_base_instalasi,
                &$tax_base_manage_service,
                &$tax_base_lain_lain,
                &$tax_base_aplikasi
            ) {
                $invoice_customer_product_additional = $invoice_customer_product->invoice_customer_product_additionals()->create([
                    'product_additional_id' => $additional->product_additional_id,
                    'additional_name' => $additional->additional_name,

                    'ar_invoice_item_category_id' => $additional->ar_invoice_item_category_id,

                    'total' => $additional->additional_price,
                    'total_usd' => $additional->additional_price_usd,
                    'total_sgd' => $additional->additional_price_sgd,

                    'customer_product_additional_id' => $additional->id,
                ]);

                $tax_base += $invoice_customer_product_additional->total;
                $tax_base_usd += $invoice_customer_product_additional->total_usd;
                $tax_base_sgd += $invoice_customer_product_additional->total_sgd;

                if ($invoice_customer_product_additional->item_category) {
                    switch ($invoice_customer_product_additional->item_category->name) {
                        case 'Bandwidth':
                            $tax_base_bandwidth += $invoice_customer_product_additional->total;
                            break;

                        case 'Data Center':
                            $tax_base_data_center += $invoice_customer_product_additional->total;
                            break;

                        case 'Instalasi':
                            $tax_base_instalasi += $invoice_customer_product_additional->total;
                            break;

                        case 'Manage Service':
                            $tax_base_manage_service += $invoice_customer_product_additional->total;
                            break;

                        case 'Lain-Lain':
                            $tax_base_lain_lain += $invoice_customer_product_additional->total;
                            break;

                        case 'Aplikasi':
                            $tax_base_aplikasi += $invoice_customer_product_additional->total;
                            break;
                    }
                }
            });

            // discount
            $customer_product->customer_product_discounts->each(function ($discount_input) use (
                $invoice_customer_product,
                &$tax_base,
                &$tax_base_usd,
                &$tax_base_sgd,
                &$discount,
                &$discount_usd,
                &$discount_sgd
            ) {
                $invoice_customer_product_discount = $invoice_customer_product->invoice_customer_product_discounts()->create([
                    'discount_name' => $discount_input->discount_name,

                    'total' => $discount_input->discount_price,
                    'total_usd' => $discount_input->discount_price_usd,
                    'total_sgd' => $discount_input->discount_price_sgd,

                    'customer_product_additional_id' => $discount_input->id,
                ]);

                $discount += $invoice_customer_product_discount->total;
                $discount_usd += $invoice_customer_product_discount->total_usd;
                $discount_sgd += $invoice_customer_product_discount->total_sgd;

                $tax_base -= $invoice_customer_product_discount->total;
                $tax_base_usd -= $invoice_customer_product_discount->total_usd;
                $tax_base_sgd -= $invoice_customer_product_discount->total_sgd;
            });

            // payments
            $customer_product->customer_product_payments->each(function ($payment) use ($invoice_obj) {
                $cash_bank = $payment->cash_bank;

                $invoice_obj->invoice_billings()->create([
                    'cash_bank_id' => $cash_bank->id,
                    'bank_name' => $cash_bank->bank ? $cash_bank->bank->name : null,
                    'bank_branch' => $cash_bank->bank_branch,
                    'on_behalf_of' => $cash_bank->on_behalf_of,
                    'number' => $cash_bank->number,
                    'is_virtual_account' => $cash_bank->is_virtual_account,
                    'customer_product_payment_id' => $payment->id,
                ]);
            });

            $tax_rate = 10;
            if ($invoice_obj->date->gte(Carbon::create(2022, 4, 1, 0))) {
                $tax_rate = 11;
            }
            if ($invoice_obj->tax_rate) {
                $tax_rate = $invoice_obj->tax_rate;
            }

            $tax = floor($tax_base * $tax_rate / 100);
            $tax_usd = floor($tax_base_usd * $tax_rate / 100);
            $tax_sgd = floor($tax_base_sgd * $tax_rate / 100);

            if (! $invoice_obj->is_tax) {
                $tax = 0;
                $tax_usd = 0;
                $tax_sgd = 0;
            }

            $total = $tax + $tax_base;
            $total_usd = $tax_usd + $tax_base_usd;
            $total_sgd = $tax_sgd + $tax_base_sgd;

            $invoice_obj->discount = $discount;
            $invoice_obj->tax_base = $tax_base;
            $invoice_obj->tax = $tax;
            $invoice_obj->total = $total;

            $invoice_obj->tax_base_bandwidth = $tax_base_bandwidth;
            $invoice_obj->tax_base_data_center = $tax_base_data_center;
            $invoice_obj->tax_base_instalasi = $tax_base_instalasi;
            $invoice_obj->tax_base_manage_service = $tax_base_manage_service;
            $invoice_obj->tax_base_lain_lain = $tax_base_lain_lain;
            $invoice_obj->tax_base_aplikasi = $tax_base_aplikasi;

            $invoice_obj->discount_usd = $discount_usd;
            $invoice_obj->discount_sgd = $discount_sgd;

            $invoice_obj->tax_base_usd = $tax_base_usd;
            $invoice_obj->tax_base_sgd = $tax_base_sgd;

            $invoice_obj->tax_usd = $tax_usd;
            $invoice_obj->tax_sgd = $tax_sgd;

            $invoice_obj->total_usd = $total_usd;
            $invoice_obj->total_sgd = $total_sgd;

            $invoice_obj->save();

            $invoice_obj->refresh();
            ArInvoice::enterpriseCreatePdf($invoice_obj);
            TaxOut::create($invoice_obj);

            if ($invoice_obj->memo) {
                ApInvoice::createMemo($invoice_obj);
            }
        }
    }
}
