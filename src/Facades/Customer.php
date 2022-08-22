<?php

namespace Gmedia\IspSystem\Facades;

use Illuminate\Support\Facades\App as FacadesApp;
use Gmedia\IspSystem\Facades\Mail as MailFac;
use Gmedia\IspSystem\Jobs\MoveFile;
use Gmedia\IspSystem\Mail\Customer\VerificationMail;
use Gmedia\IspSystem\Models\ArInvoice;
use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\Customer as CustomerModel;
use Gmedia\IspSystem\Models\CustomerEmail;
use Gmedia\IspSystem\Models\CustomerPhoneNumber;
use Gmedia\IspSystem\Models\CustomerProduct;
use Gmedia\IspSystem\Models\CustomerProductAdditional;
use Gmedia\IspSystem\Models\PreCustomer;
use Gmedia\IspSystem\Models\PreCustomerProduct;
use Gmedia\IspSystem\Models\PreCustomerProductAdditional;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Customer
{
    public static function generateCid(Branch $branch)
    {
        $log = applog('erp, customer__fac, generate_cid');
        $log->save('debug');

        $cid = null;

        do {
            $random_number = Faker::create()->regexify('[0-9]{4}');
            $cid = $branch->code.date('my').$random_number;
        } while (
            // checking in customer
            CustomerModel::where('cid', $cid)->exists() or
            CustomerProduct::where('sid', 'like', $cid.'%')->exists() or
            CustomerProductAdditional::where('sid', 'like', $cid.'%')->exists() or
            // checking in pre_customer
            PreCustomer::where('cid', $cid)->exists() or
            PreCustomerProduct::where('sid', 'like', $cid.'%')->exists() or
            PreCustomerProductAdditional::where('sid', 'like', $cid.'%')->exists()
        );

        return $cid;
    }

    public static function generateSid(CustomerModel $customer = null, PreCustomer $pre_customer = null)
    {
        $log = applog('erp, customer__fac, generate_sid');
        $log->save('debug');

        $cid = null;
        if ($pre_customer) $cid = $pre_customer->cid;
        if ($customer) $cid = $customer->cid;
        if (!$cid) return null;

        $sid = null;

        $number = 0;
        do {
            $number++;
            $string_number = sprintf('%02d', $number);
            $sid = $cid.$string_number;
        } while (
            CustomerProduct::where('sid', $sid)->exists() or
            PreCustomerProduct::where('sid', $sid)->exists()
        );

        return $sid;
    }

    public static function generateSidForAdditional(CustomerProduct $customer_product = null, PreCustomerProduct $pre_customer_product = null)
    {
        $log = applog('erp, customer__fac, generate_sid_for_additional');
        $log->save('debug');

        $sid_product = null;
        if ($pre_customer_product) $sid_product = $pre_customer_product->sid;
        if ($customer_product) $sid_product = $customer_product->sid;
        if (!$sid_product) return null;

        $sid = null;

        $number = 0;
        do {
            $number++;
            $string_number = sprintf('%02d', $number);
            $sid = $customer_product->sid.$string_number;
        } while (
            CustomerProductAdditional::where('sid', $sid)->exists() or
            PreCustomerProductAdditional::where('sid', $sid)->exists()
        );

        return $sid;
    }

    public static function createFromPreCustomer(PreCustomer $pre_customer)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'create_form_pre_customer'
        );
        $log->save('debug');

        $customer = CustomerModel::create([
            'cid' => $pre_customer->cid,
            'name' => $pre_customer->name,
            'alias_name' => $pre_customer->alias_name,

            'province_id' => $pre_customer->province_id,
            'district_id' => $pre_customer->district_id,
            'sub_district_id' => $pre_customer->sub_district_id,
            'village_id' => $pre_customer->village_id,
            'postal_code' => $pre_customer->postal_code,
            'address' => $pre_customer->address,
            'latitude' => $pre_customer->latitude,
            'longitude' => $pre_customer->longitude,

            'identity_card' => $pre_customer->identity_card,
            'identity_card_file' => $pre_customer->identity_card_file,
            'npwp' => $pre_customer->npwp,
            'previous_isp_id' => $pre_customer->previous_isp_id,
            'previous_isp_price' => $pre_customer->previous_isp_price,
            'previous_isp_bandwidth' => $pre_customer->previous_isp_bandwidth,
            'previous_isp_bandwidth_unit_id' => $pre_customer->previous_isp_bandwidth_unit_id,
            'previous_isp_bandwidth_type_id' => $pre_customer->previous_isp_bandwidth_type_id,
            'previous_isp_feature' => $pre_customer->previous_isp_feature,

            'house_photo' => $pre_customer->house_photo,

            'branch_id' => $pre_customer->branch_id,
            'brand_id' => $pre_customer->brand_id,
        ]);

        $customer->phone_numbers()
            ->createMany($pre_customer->phone_numbers->map(function ($phone_number) {
                return [
                    'number' => $phone_number->number,
                    'whatsapp' => $phone_number->whatsapp,
                    'telegram' => $phone_number->telegram,
                ];
            })->all());

        $customer->emails()
            ->createMany($pre_customer->emails->map(function ($email) {
                return [
                    'name' => $email->name,
                ];
            })->all());

        $pre_customer->pre_customer_products->each(function ($pre_customer_product) use ($customer) {
            $customer_product = $customer->customer_products()->create([
                'sid' => $pre_customer_product->sid,
                'product_id' => $pre_customer_product->product_id,

                'media_id' => $pre_customer_product->media_id,
                'media_vendor_id' => $pre_customer_product->media_vendor_id,

                'agent_id' => $pre_customer_product->agent_id,
                'sales' => $pre_customer_product->sales,

                'public_facility' => $pre_customer_product->public_facility,

                'hybrid' => true,
                'ignore_prorated' => true,
                'ignore_tax' => false,
                'postpaid' => true,

                'radius_username' => $pre_customer_product->radius_username,
                'radius_password' => $pre_customer_product->radius_password,

                'pre_customer_product_id' => $pre_customer_product->pre_customer_product_id,
            ]);

            $additionals = $pre_customer_product->pre_customer_product_additionals
                ->each(function ($pre_customer_product_additional) {
                    $key = $pre_customer_product_additional->product_additional_id;
                    $value = [
                        'sid' => $pre_customer_product_additional->sid,
                    ];

                    return [$key => $value];
                });
            $customer_product->additionals()->attach($additionals);
        });

        // identity_card_file
        if ($pre_customer->identity_card_file) {
            $log->save('move identity card file');

            $from_disk = config('filesystems.primary_disk');
            if (config('filesystems.temporary_disk')) $from_disk = config('filesystems.temporary_disk');
            $from_path = 'pre_customer_identity_card/' . $pre_customer->identity_card_file;

            if (Storage::disk($from_disk)->exists($from_path)) {
                $to_disk = config('filesystems.primary_disk');
                $to_path = 'customer_identity_card/' . $pre_customer->identity_card_file;

                dispatch(new MoveFile($from_disk, $from_path, $to_disk, $to_path));

                if (config('filesystems.temporary_disk')) {
                    $to_disk = config('filesystems.temporary_disk');
                    dispatch(new MoveFile($from_disk, $from_path, $to_disk, $to_path));
                }
            }
        }

        // house_photo
        if ($pre_customer->house_photo) {
            $log->save('move house photo');

            $from_disk = config('filesystems.primary_disk');
            if (config('filesystems.temporary_disk')) $from_disk = config('filesystems.temporary_disk');
            $from_path = 'pre_customer_house_photo/' . $pre_customer->house_photo;

            if (Storage::disk($from_disk)->exists($from_path)) {
                $to_disk = config('filesystems.primary_disk');
                $to_path = 'customer_house_photo/' . $pre_customer->house_photo;

                dispatch(new MoveFile($from_disk, $from_path, $to_disk, $to_path));

                if (config('filesystems.temporary_disk')) {
                    $to_disk = config('filesystems.temporary_disk');
                    dispatch(new MoveFile($from_disk, $from_path, $to_disk, $to_path));
                }
            }
        }

        $customer->refresh();
        ArInvoiceScheme::createCustomerScheme($customer);
    }

    public static function correctingDiscount(CustomerProduct $customer_product, $billing_date)
    {
        $log = applog('erp, customer__fac, correcting_discount');
        $log->save('debug');

        $customer_product->customer_product_discounts->each(function ($customer_product_discount) use ($customer_product, $billing_date) {
            $customer_product_discount->start_date = $customer_product->postpaid ? $billing_date->addMonthNoOverflow() : $billing_date;

            if ($customer_product_discount->product_discount->discount->name === 'Diskon 20% Dokter dan Tenaga Medis') {
                $customer_product_discount->end_date = null;
            }

            if ($customer_product_discount->product_discount->discount->name === 'Pay 75% HUT RI') {
                $customer_product_discount->end_date = $customer_product_discount->start_date->addMonthsNoOverflow(12)->subDay();
            }

            if ($customer_product_discount->product_discount->discount->name === 'HUT RI 76') {
                $customer_product_discount->end_date = $customer_product_discount->start_date->addMonthNoOverflow()->subDay();
            }

            $customer_product_discount->save();
        });
    }

    public static function updateService(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_service');
        $log->save('debug');

        $customer->load([
            'customer_products',
            'customer_products.product',
            'customer_products.product.payment_scheme',
        ]);

        $active = false;
        $customer->customer_products->each(function ($customer_product) use (&$active) {
            if ($customer_product->product) {
                if ($customer_product->product->payment_scheme->name === 'Monthly') {
                    if ($customer_product->service_start_date) {
                        if ($customer_product->service_end_date) {
                            if (
                                Carbon::now()->gte($customer_product->service_start_date)
                                && Carbon::now()->lte($customer_product->service_end_date)
                            ) $active = true;
                        } else {
                            if (Carbon::now()->gte($customer_product->service_start_date)) {
                                $active = true;
                            }
                        }
                    }
                } else {
                    if ($customer_product->service_date) {
                        if (
                            Str::contains($customer_product->product->name, '5 Bulan')
                            && Carbon::now()->gte($customer_product->service_date)
                            && Carbon::now()->lte($customer_product->service_date->addMonthsNoOverflow(4)->endOfMonth())
                        ) $active = true;

                        if (
                            Str::contains($customer_product->product->name, '9 Bulan')
                            && Carbon::now()->gte($customer_product->service_date)
                            && Carbon::now()->lte($customer_product->service_date->addMonthsNoOverflow(8)->endOfMonth())
                        ) $active = true;

                        if (Carbon::now()->eq($customer_product->service_date)) {
                            $active = true;
                        }
                    }
                }
            }
        });

        $customer->service = $active;
        $customer->save();
    }

    public static function updateBilling(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_billing');
        $log->save('debug');

        $customer->load([
            'customer_products',
            'customer_products.product',
            'customer_products.product.payment_scheme',
        ]);

        $active = false;
        $customer->customer_products->each(function ($customer_product) use (&$active) {
            if ($customer_product->product) {
                if ($customer_product->product->payment_scheme->name === 'Monthly') {
                    if ($customer_product->billing_start_date) {
                        if ($customer_product->billing_end_date) {
                            if (
                                Carbon::now()->gte($customer_product->billing_start_date)
                                && Carbon::now()->lte($customer_product->billing_end_date)
                            ) $active = true;
                        } else {
                            if (Carbon::now()->gte($customer_product->billing_start_date)) {
                                $active = true;
                            }
                        }
                    }
                } else {
                    if ($customer_product->billing_date) {
                        if (
                            Str::contains($customer_product->product->name, '5 Bulan')
                            && Carbon::now()->gte($customer_product->billing_date)
                            && Carbon::now()->lte($customer_product->billing_date->addMonthsNoOverflow(4)->endOfMonth())
                        ) $active = true;

                        if (
                            Str::contains($customer_product->product->name, '9 Bulan')
                            && Carbon::now()->gte($customer_product->billing_date)
                            && Carbon::now()->lte($customer_product->billing_date->addMonthsNoOverflow(8)->endOfMonth())
                        ) $active = true;

                        if (Carbon::now()->eq($customer_product->billing_date)) {
                            $active = true;
                        }
                    }
                }

                if ($active) if ($customer_product->adjusted_price) {
                    if (!($customer_product->special_price > 0)) {
                        $active = false;
                    }
                } else {
                    if (!($customer_product->product->price > 0)) {
                        $active = false;
                    }
                }
            }
        });

        $customer->billing = $active;
        $customer->save();
    }

    public static function updateSubsidy(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_subsidy');
        $log->save('debug');

        $customer->load([
            'customer_products',
            'customer_products.product',
        ]);

        $subsidy = false;
        $customer->customer_products->each(function ($customer_product) use (&$subsidy) {
            if (!$customer_product->product) return true;

            if (Str::contains($customer_product->product->name, 'Subsidy')) {
                $subsidy = true;
            }

            $customer_product->subsidy = $subsidy;
            $customer_product->save();
        });

        $customer->subsidy = $subsidy;
        $customer->save();
    }

    public static function updatePublicFacility(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_public_facility');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $public_facility = false;
        $customer->customer_products->each(function ($customer_product) use (&$public_facility) {
            if ($customer_product->public_facility) {
                $public_facility = true;
            }
        });

        $customer->public_facility = $public_facility;
        $customer->save();
    }

    public static function updateIncludeTax(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_include_tax');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $price_include_tax = false;
        $customer->customer_products->each(function ($customer_product) use (&$price_include_tax) {
            if ($customer_product->product && $customer_product->product->price_include_tax) {
                $price_include_tax = true;
            }
        });

        $customer->price_include_tax = $price_include_tax;
        $customer->save();
    }

    public static function enterpriseUpdateActive(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, enterprise_update_active');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $active = false;
        $customer->customer_products->each(function ($customer_product) use (&$active) {
            if ($customer_product->active) $active = true;
        });

        $customer->active = $active;
        $customer->save();
    }

    public static function enterpriseUpdateTax(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, enterprise_update_tax');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $tax = false;
        $customer->customer_products->each(function ($customer_product) use (&$tax) {
            if ($customer_product->tax) $tax = true;
        });

        $customer->tax = $tax;
        $customer->save();
    }

    public static function enterpriseUpdateBillingCycle(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, enterprise_update_billing_cycle');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $billing_cycle = false;
        $customer->customer_products->each(function ($customer_product) use (&$billing_cycle) {
            if ($customer_product->billing_cycle) $billing_cycle = true;
        });

        $customer->billing_cycle = $billing_cycle;
        $customer->save();
    }

    public static function updateJsonProduct(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_json_product');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $products = [];
        $customer->customer_products->each(function ($customer_product) use (&$products) {
            array_push($products, ['id' => $customer_product->product_id]);
        });

        $customer->json_products = json_encode($products);
        $customer->save();
    }

    public static function updateJsonProductTag(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_json_product_tag');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $product_tags = [];
        $customer->customer_products->each(function ($customer_product) use (&$product_tags) {
            if (!$customer_product->product) return true;

            $customer_product_tags = [];
            $customer_product->product->tags->each(function ($tag) use (&$customer_product_tags) {
                array_push($customer_product_tags, ['id' => $tag->id]);
            });

            array_merge($product_tags, $customer_product_tags);
            $customer_product->json_product_tags = json_encode($customer_product_tags);
            $customer_product->save();
        });

        $customer->json_product_tags = json_encode($product_tags);
        $customer->save();
    }

    public static function updateJsonAgent(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_json_agent');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $agents = [];
        $customer->customer_products->each(function ($customer_product) use (&$agents) {
            array_push($agents, ['id' => $customer_product->agent_id]);
        });

        $customer->json_agents = json_encode($agents);
        $customer->save();
    }

    public static function updateJsonPhoneNumber(CustomerModel $customer)
    {
        $log = applog('erp, customer__fac, update_json_phone_number');
        $log->save('debug');

        $phone_numbers = [];
        $customer->phone_numbers->each(function ($phone_number) use (&$phone_numbers) {
            array_push($phone_numbers, [
                'id' => $phone_number->id,
                'number' => $phone_number->number,
            ]);
        });

        $customer->json_phone_numbers = json_encode($phone_numbers);
        $customer->save();
    }

    public static function updateInstallationInvoiceEmailDate(ArInvoice $invoice)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'update_installation_invoice_email_date'
        );
        $log->save('debug');

        $invoice_customer = $invoice->invoice_customers->first();
        if (!$invoice_customer) return;

        $invoice_customer_product_additional = $invoice_customer
            ->invoice_customer_product_additionals()
            ->where('customer_product_additional_name', 'Installation and Activation')
            ->first();
        if (!$invoice_customer_product_additional) return;

        $customer_product_additional = $invoice_customer_product_additional
            ->customer_product_additional;
        if (!$customer_product_additional) return;

        $customer_product = $customer_product_additional
            ->customer_product;
        if (!$customer_product) return;

        $log->save('relation found');
        $customer_product->installation_invoice_email_at = $invoice->email_sent_at;
        $customer_product->save();
    }

    public static function updateInstallationInvoiceWhatsappDate(ArInvoice $invoice)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'update_installation_invoice_whatsapp_date'
        );
        $log->save('debug');

        $invoice_customer = $invoice->invoice_customers->first();
        if (!$invoice_customer) return;

        $invoice_customer_product_additional = $invoice_customer
            ->invoice_customer_product_additionals()
            ->where('customer_product_additional_name', 'Installation and Activation')
            ->first();
        if (!$invoice_customer_product_additional) return;

        $customer_product_additional = $invoice_customer_product_additional
            ->customer_product_additional;
        if (!$customer_product_additional) return;

        $customer_product = $customer_product_additional
            ->customer_product;
        if (!$customer_product) return;

        $log->save('relation found');
        $customer_product->installation_invoice_whatsapp_at = $invoice->whatsapp_sent_at;
        $customer_product->save();
    }

    public static function updateInstallationInvoiceDueDate(ArInvoice $invoice)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'update_installation_invoice_due_date'
        );
        $log->save('debug');

        $invoice_customer = $invoice->invoice_customers->first();
        if (!$invoice_customer) return;

        $invoice_customer_product_additional = $invoice_customer
            ->invoice_customer_product_additionals()
            ->where('customer_product_additional_name', 'Installation and Activation')
            ->first();
        if (!$invoice_customer_product_additional) return;

        $customer_product_additional = $invoice_customer_product_additional
            ->customer_product_additional;
        if (!$customer_product_additional) return;

        $customer_product = $customer_product_additional
            ->customer_product;
        if (!$customer_product) return;

        $log->save('relation found');
        $customer_product->installation_invoice_due_date = $invoice->due_date;
        $customer_product->save();
    }

    public static function updateInstallationInvoicePaidDate(ArInvoice $invoice)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'update_installation_invoice_paid_date'
        );
        $log->save('debug');

        $invoice_customer = $invoice->invoice_customers->first();
        if (!$invoice_customer) return;

        $invoice_customer_product_additional = $invoice_customer
            ->invoice_customer_product_additionals()
            ->where('customer_product_additional_name', 'Installation and Activation')
            ->first();
        if (!$invoice_customer_product_additional) return;

        $customer_product_additional = $invoice_customer_product_additional
            ->customer_product_additional;
        if (!$customer_product_additional) return;

        $customer_product = $customer_product_additional
            ->customer_product;
        if (!$customer_product) return;

        $log->save('relation found');
        $customer_product->installation_invoice_paid_at = $invoice->paid_at;
        $customer_product->save();
    }

    public static function updatePaymentActiveStatusByInvoice(ArInvoice $invoice)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'update_payment_active_status_by_invoice'
        );
        $log->save('debug');

        $invoice_customer = $invoice->invoice_customers->first();
        if (!$invoice_customer) return;

        $customer_product = null;

        if (!$customer_product) {
            $invoice_customer_product = $invoice_customer
                ->invoice_customer_products
                ->first();

            if ($invoice_customer_product) {
                $customer_product = $invoice_customer_product
                    ->customer_product;
            }
        }

        if (!$customer_product) {
            $invoice_customer_product_additional = $invoice_customer
                ->invoice_customer_product_additionals
                ->first();

            if ($invoice_customer_product_additional) {
                $customer_product_additional = $invoice_customer_product_additional
                    ->customer_product_additional;

                if ($customer_product_additional) {
                    $customer_product = $customer_product_additional
                        ->customer_product;
                }
            }
        }

        if (!$customer_product) return;

        $log->save('relation found');
        static::updatePaymentActiveStatus($customer_product);
    }

    public static function updatePaymentActiveStatus(CustomerProduct $customer_product)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'update_payment_active_status'
        );
        $log->save('debug');

        $payment_is_active = true;

        foreach ($customer_product->invoice_products()->cursor() as $invoice_product) {
            $invoice_customer = $invoice_product->invoice_customer;
            if ($invoice_customer)
            {
                $invoice = $invoice_customer->invoice;
                if ($invoice && !$invoice->paid)
                {
                    $payment_is_active = false;
                }
            }
        }

        $customer_product->load(['customer_product_additionals']);
        foreach ($customer_product->customer_product_additionals as $customer_product_additional) {
            foreach ($customer_product_additional->invoice_additionals()->cursor() as $invoice_additional) {
                $invoice_customer_product = $invoice_additional->invoice_customer_product;
                if ($invoice_customer_product)
                {
                    $invoice_customer = $invoice_customer_product->invoice_customer;
                    if ($invoice_customer)
                    {
                        $invoice = $invoice_customer->invoice;
                        if ($invoice && !$invoice->paid)
                        {
                            $payment_is_active = false;
                        }
                    }
                }
            }
        }

        $customer_product->payment_is_active = $payment_is_active;
        $customer_product->save();
    }

    public static function sendEmailVerification(CustomerEmail $customer_email)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'send_email_verification'
        );
        $log->save('debug');

        if (!$customer_email->name) return;
        if (!$customer_email->customer) return;

        if (!$customer_email->customer->brand) {
            $log->save('invalid brand');
            return;
        }

        $to = $customer_email->name;
        $cc = [];

        $log->new()->properties(['to' => $to, 'cc' => $cc])->save('email address');

        try {
            $default_mail = Mail::getSwiftMailer();
            $verification_mail = MailFac::getSwiftMailer('default');
            if (in_array(FacadesApp::environment(), ['development', 'testing'])) {
                $to = config('app.dev_mail_address');
                $cc = config('app.dev_cc_mail_address');
                $verification_mail = MailFac::getSwiftMailer('dev');
            }
            Mail::setSwiftMailer($verification_mail);

            Mail::to($to)->cc($cc)->send(new VerificationMail([
                'brand_name' => $customer_email->customer->brand->name,
                'customer_name' => $customer_email->customer->name,

                'email' => $customer_email->name,
                'email_uuid' => $customer_email->uuid,

                'company_name' => $customer_email->customer->branch->regional->company->name,
                'company_address' => $customer_email->customer->branch->regional->address,
                'company_phone_number' => $customer_email->customer->branch->regional->phone_number,
            ]));

            Mail::setSwiftMailer($default_mail);

            $customer_email->update([
                'verification_email_sent_at' => Carbon::now()->toDateTimeString(),
            ]);

            return true;
        } catch (\Exception $e) {
            $log->new()->properties($e->getMessage())->save('error');
            return false;
        }
    }

    public static function sendPhoneNumberVerification(CustomerPhoneNumber $customer_phone_number)
    {
        $log = applog(
            'erp, '.
            'customer__fac, '.
            'send_phone_number_verification'
        );
        $log->save('debug');

        $phone_numbers = [$customer_phone_number->number];

        if (!FacadesApp::environment('production')) {
            $dev_phone_numbers = config('app.dev_phone_numbers');

            if (FacadesApp::environment(['staging', 'development']) && $dev_phone_numbers) {
                $phone_numbers = $dev_phone_numbers;
            } else {
                return response(['message' => 'Delivery failed'], 500);
            }
        }

        $template_name = 'phone_number_verification';

        $components = [
            [
                'type' => 'body',
                'parameters' => [],
            ],
            [
                'type' => 'button',
                'index' => '0',
                'sub_type' => 'url',
                'parameters' => [
                    [
                        'type' => 'text',
                        'text' => $customer_phone_number->uuid,
                    ],
                ],
            ],
        ];

        $success = Whatsapp::sendMultipleReceivers($template_name, null, $phone_numbers, true, $components);
        if (!$success) {
            return false;
        }

        $customer_phone_number->update([
            'whatsapp_verification_sent_at' => Carbon::now()->toDateTimeString(),
        ]);

        return true;
    }
}
