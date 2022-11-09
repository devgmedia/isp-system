<?php

namespace Gmedia\IspSystem\Facades;

use Carbon\Carbon;
use Gmedia\IspSystem\Models\ArInvoiceFaktur;
use Gmedia\IspSystem\Models\ArInvoiceItemCategory;
use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\CashBank;
use Gmedia\IspSystem\Models\Customer;
use Gmedia\IspSystem\Models\CustomerCategory;
use Gmedia\IspSystem\Models\CustomerProduct;
use Gmedia\IspSystem\Models\ProductBrand;
use Gmedia\IspSystem\Models\Regional;
use Gmedia\IspSystem\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Output\ConsoleOutput;

class Erp1
{
    public static function migrateCustomer(
        $customer,
        $conn,
        Branch $branch,
        CustomerCategory $category = null
    ) {
        $log = applog('erp, erp1__fac, migrate_customer');
        $log->save('debug');

        // uuid
        $uuid = $customer->uuid;

        if (! $uuid) {
            do {
                $uuid = Uuid::uuid4();
            } while (
                Customer::where('uuid', $uuid)->exists()
                or DB::connection($conn)->table('gmd_finance_customer')->where('uuid', $uuid)->exists()
            );

            DB::connection($conn)
                ->table('gmd_finance_customer')
                ->where('id', $customer->id)
                ->update(['uuid' => $uuid]);
        }

        static::migrateCustomerUuid($uuid, $conn, $branch, $category);
    }

    public static function migrateCustomerUuid(
        $uuid,
        $conn,
        Branch $branch,
        CustomerCategory $category = null
    ) {
        $log = applog('erp, erp1__fac, migrate_customer_uuid');
        $log->save('debug');

        $output = new ConsoleOutput();
        $output->writeln('<info>Uuid:</info> '.$uuid);

        $customer = DB::connection($conn)
            ->table('gmd_finance_customer')
            ->where('uuid', $uuid)
            ->first();

        $output->writeln('<comment>Perparing migrate . . .</comment>');
        $output->writeln('<info>Customer id:</info> '.$customer->id);

        $migration_issue = [];

        /** clearing resources */
        DB::connection($conn)
            ->table('gmd_finance_customer')
            ->where('id', $customer->id)
            ->update(['migration_issue' => null]);

        /** collecting values */

        // cid
        if (! $customer->customer_id) {
            $output->writeln('empty cid');
            $output->writeln('deleted');

            Customer::where('uuid', $uuid)->delete();

            return;
        }
        $cid = $customer->customer_id;
        $cid = preg_replace('/[^0-9]/i', '', $cid);
        // if ($cid === '') $cid = FacadesCustomer::generateCid($branch);
        $output->writeln('cid: '.$cid);

        // user_id
        $user_id = null;

        $user = User::where('name', $cid)->first();
        if ($user) {
            if (Customer::where('user_id', $user->id)->exists()) {
                array_push($migration_issue, ['message' => 'User is conflict.']);
            } else {
                $user_id = $user->id;
            }
        }

        // name
        $name = $customer->nama;
        $name = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $name);
        $name = substr($name, 0, 50);
        $output->writeln('name: '.$name);

        // address
        $address = $customer->alamat;
        $address = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $address);
        $output->writeln('address: '.$address);

        $validator = Validator::make(['address' => $address], [
            'address' => "nullable|string|regex:/^[A-Za-z0-9&,:;!?@#%='_\[\]\/\.\-\+\(\)\*\s]+$/",
        ], [
            'address.string' => 'A :attribute must be string.',
            'address.regex' => 'Invalid :attribute.',
        ]);

        if ($validator->fails()) {
            array_push($migration_issue, $validator->errors()->all());
            $address = null;
        }

        // category
        $category_id = $category ? $category->id : null;
        $output->writeln('category_id: '.$category_id);

        $validator = Validator::make(['category_id' => $category_id], [
            'category_id' => 'nullable|exists:Gmedia\IspSystem\Models\Branch,id',
        ], [
            'category_id.string' => 'A :attribute must be string.',
            'category_id.regex' => 'Invalid :attribute.',
        ]);

        if ($validator->fails()) {
            array_push($migration_issue, $validator->errors()->all());
            $category_id = null;
        }

        // phone_number
        $phone_number = $customer->telp;
        $phone_number = preg_replace("/[^0-9+()\s]/i", '', $phone_number);
        $output->writeln('phone_number: '.$phone_number);

        $validator = Validator::make(['phone_number' => $phone_number], [
            'phone_number' => "nullable|string|regex:/^[0-9+()]{1}[0-9+()\s]{1,18}[0-9+()]{1}$/",
        ], [
            'phone_number.string' => 'A :attribute must be string.',
            'phone_number.regex' => 'Invalid :attribute.',
        ]);

        if ($validator->fails()) {
            array_push($migration_issue, $validator->errors()->all());
            $phone_number = null;
        }

        // branch_id
        $branch_id = $branch->id;
        $output->writeln('branch_id: '.$branch_id);

        // brand_id
        $brand_id = ProductBrand::where('name', 'GMEDIA')->value('id');
        $output->writeln('brand_id: '.$brand_id);

        $values = [
            'uuid' => $uuid,
            'cid' => $cid,
            'name' => $name,
            'branch_id' => $branch_id,
            'brand_id' => $brand_id,
            'user_id' => $user_id,
        ];

        /** validating required values */
        $validator = Validator::make($values, [
            'uuid' => 'required',
            'cid' => 'required',
            'name' => [
                'required',
                'string',
                'min:3',
                'max:128',
                "regex:/^[A-Za-z0-9&,:;!?@#%='_\[\]\/\.\-\+\(\)\*\s]+$/",
            ],
            'address' => "nullable|string|regex:/^[A-Za-z0-9&,:;!?@#%='_\[\]\/\.\-\+\(\)\*\s]+$/",
            'category_id' => 'nullable|exists:Gmedia\IspSystem\Models\Branch,id',
            'branch_id' => 'required|exists:Gmedia\IspSystem\Models\Branch,id',
            'brand_id' => 'required|exists:Gmedia\IspSystem\Models\ProductBrand,id',
        ], [
            'uuid.required' => 'A :attribute is required.',

            'cid.required' => 'A :attribute is required.',

            'name.required' => 'A :attribute is required.',
            'name.string' => 'A :attribute must be string.',
            'name.min' => 'A :attribute must be at least :min characters.',
            'name.max' => 'A :attribute must be a maximum :max characters.',
            'name.regex' => 'Invalid :attribute.',

            'branch_id.exists' => 'Branch not found.',
            'branch_id.required' => 'A branch is required.',

            'brand_id.exists' => 'Brand not found.',
            'brand_id.required' => 'A brand is required.',
        ]);

        if ($validator->fails()) {
            array_push($migration_issue, $validator->errors()->all());
            $output->writeln('migration_issue: '.json_encode($migration_issue));

            DB::connection($conn)
                ->table('gmd_finance_customer')
                ->where('id', $customer->id)
                ->update(['migration_issue' => json_encode($migration_issue)]);

            return;
        }

        /** saving values */
        $new_customer = Customer::where('uuid', $uuid)->first();

        if ($new_customer) {
            $id = $new_customer->id;

            $validator = Validator::make($values, [
                'uuid' => [
                    Rule::unique('customer')->where(function ($query) use ($uuid, $id) {
                        return $query->where([
                            ['uuid', '=', $uuid],
                            ['id', '<>', $id],
                        ]);
                    }),
                ],
                'cid' => [
                    Rule::unique('customer')->where(function ($query) use ($cid, $id) {
                        return $query->where([
                            ['cid', '=', $cid],
                            ['id', '<>', $id],
                        ]);
                    }),
                ],
                'name' => [
                    Rule::unique('customer')->where(function ($query) use ($name, $branch_id, $id) {
                        return $query->where([
                            ['name', '=', $name],
                            ['branch_id', '=', $branch_id],
                            ['id', '<>', $id],
                        ]);
                    }),
                ],
            ], [
                'uuid.unique' => 'The :attribute must be unused.',
                'cid.unique' => 'The :attribute must be unused.',
                'name.unique' => 'The :attribute must be unused.',
            ]);

            if ($validator->fails()) {
                array_push($migration_issue, $validator->errors()->all());
                $output->writeln('migration_issue: '.json_encode($migration_issue));

                DB::connection($conn)
                    ->table('gmd_finance_customer')
                    ->where('id', $customer->id)
                    ->update(['migration_issue' => json_encode($migration_issue).', Id: '.$id]);

                return;
            }

            $new_customer->update($values);

            $new_customer->user()->update(['name' => $new_customer->cid]);
        } else {
            $validator = Validator::make($values, [
                'uuid' => 'unique:Gmedia\IspSystem\Models\Customer,uuid',
                'cid' => 'unique:Gmedia\IspSystem\Models\Customer,cid',
                'name' => [
                    Rule::unique('customer')->where(function ($query) use ($name, $branch_id) {
                        return $query->where([
                            ['name', '=', $name],
                            ['branch_id', '=', $branch_id],
                        ]);
                    }),
                ],
            ], [
                'uuid.unique' => 'The :attribute must be unused.',
                'cid.unique' => 'The :attribute must be unused.',
                'name.unique' => 'The :attribute must be unused.',
            ]);

            if ($validator->fails()) {
                array_push($migration_issue, $validator->errors()->all());
                $output->writeln('migration_issue: '.json_encode($migration_issue));

                DB::connection($conn)
                    ->table('gmd_finance_customer')
                    ->where('id', $customer->id)
                    ->update(['migration_issue' => json_encode($migration_issue)]);

                return;
            }

            $new_customer = Customer::create($values);
        }

        /** saving child values */
        $invoice_increment = 0;
        if ($new_customer) {
            // phone_number
            if ($phone_number) {
                $new_phone_number = $new_customer->phone_numbers->first();

                if ($new_phone_number) {
                    $new_phone_number->update(['number' => $phone_number]);
                    $new_phone_number->save();
                } else {
                    $new_phone_number = $new_customer->phone_numbers()->create(['number' => $phone_number]);
                }
            }

            // product
            DB::connection($conn)
                ->table('gmd_finance_customer_service')
                ->where('customer_id', $customer->customer_id)
                ->get()
                ->each(function ($service) use ($new_customer, $conn, $branch, $output, &$invoice_increment) {
                    // uuid
                    $uuid = $service->uuid;
                    $output->writeln('uuid: '.$uuid);

                    if (! $uuid) {
                        do {
                            $uuid = Uuid::uuid4();
                        } while (
                            CustomerProduct::where('uuid', $uuid)->exists()
                            or DB::connection($conn)->table('gmd_finance_customer_service')->where('uuid', $uuid)->exists()
                        );

                        DB::connection($conn)
                            ->table('gmd_finance_customer_service')
                            ->where('id', $service->id)
                            ->update(['uuid' => $uuid]);
                    }

                    $migration_issue = [];

                    /** clearing resources */
                    DB::connection($conn)
                        ->table('gmd_finance_customer_service')
                        ->where('id', $service->id)
                        ->update(['migration_issue' => null]);

                    /** collecting resources */

                    // sid
                    $sid = $service->service_id;
                    $sid = preg_replace('/[^0-9]/i', '', $sid);
                    // if ($sid === '') $sid = FacadesCustomer::generateSid($new_customer);
                    $output->writeln('sid: '.$sid);

                    // ar_invoice_item_category_id
                    // product_price
                    $ar_invoice_item_category_id = null;
                    $product_price = 0;

                    if ($service->aplikasi && $service->aplikasi > 0) {
                        $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Aplikasi')->value('id');
                        $product_price = $service->aplikasi;
                    }

                    if ($service->lain2 && $service->lain2 > 0) {
                        $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Lain-Lain')->value('id');
                        $product_price = $service->lain2;
                    }

                    if ($service->perangkat && $service->perangkat > 0) {
                        $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Manage Service')->value('id');
                        $product_price = $service->perangkat;
                    }

                    if ($service->instalasi && $service->instalasi > 0) {
                        $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Instalasi')->value('id');
                        $product_price = $service->instalasi;
                    }

                    if ($service->colocation && $service->colocation > 0) {
                        $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Data Center')->value('id');
                        $product_price = $service->colocation;
                    }

                    if ($service->bandwith && $service->bandwith > 0) {
                        $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Bandwidth')->value('id');
                        $product_price = $service->bandwith;
                    }

                    $output->writeln('ar_invoice_item_category_id: '.$ar_invoice_item_category_id);
                    $output->writeln('product_price: '.$product_price);

                    // product_name
                    $product_name = $service->product_description;
                    $product_name = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $product_name);
                    $product_name = substr($product_name, 0, 75);
                    $output->writeln('product_name: '.$product_name);

                    // enterprise_billing_date
                    $enterprise_billing_date = $service->date_invoice;
                    $output->writeln('enterprise_billing_date: '.$enterprise_billing_date);

                    // billing_time
                    $billing_time = null;
                    if ($service->date_invoice && $service->date_due) {
                        $date = Carbon::createFromFormat('Y-m-d', $service->date_invoice);
                        $due_date = Carbon::createFromFormat('Y-m-d', $service->date_due);

                        $billing_time = $date->diffInDays($due_date);
                    }
                    $output->writeln('billing_time: '.$billing_time);

                    // billing_cycle
                    $billing_cycle = $service->billing_cycle;
                    $output->writeln('billing_cycle: '.$billing_cycle);

                    // active
                    $active = ($service->status_service === 0);
                    $output->writeln('active: '.$active);

                    // tax
                    $tax = $service->ppn;
                    $output->writeln('tax: '.$tax);

                    // qrcode
                    $qrcode = $service->barcode;
                    $output->writeln('qrcode: '.$qrcode);

                    // ar_invoice_faktur_id
                    $ar_invoice_faktur_id = null;
                    if ($service->jenis_ppn === 0) {
                        $ar_invoice_faktur_id = ArInvoiceFaktur::where('name', 'Standar')->value('id');
                    } elseif ($service->jenis_ppn === 1) {
                        $ar_invoice_faktur_id = ArInvoiceFaktur::where('name', 'Sederhana')->value('id');
                    }
                    $output->writeln('ar_invoice_faktur_id: '.$ar_invoice_faktur_id);

                    // receiver_name
                    $receiver_name = $service->invoice_name;
                    $receiver_name = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $receiver_name);
                    $receiver_name = substr($receiver_name, 0, 100);
                    $output->writeln('receiver_name: '.$receiver_name);

                    // receiver_attention
                    $receiver_attention = $service->invoice_attention;
                    $receiver_attention = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $receiver_attention);
                    $receiver_attention = substr($receiver_attention, 0, 100);
                    $output->writeln('receiver_attention: '.$receiver_attention);

                    // receiver_address
                    $receiver_address = $service->invoice_address;
                    $receiver_address = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $receiver_address);
                    $receiver_address = substr($receiver_address, 0, 100);
                    $output->writeln('receiver_address: '.$receiver_address);

                    // receiver_phone_number
                    $receiver_phone_number = $service->invoice_phone;
                    $receiver_phone_number = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $receiver_phone_number);
                    $receiver_phone_number = substr($receiver_phone_number, 0, 100);
                    $output->writeln('receiver_phone_number: '.$receiver_phone_number);

                    // site_name
                    $site_name = $service->nama;
                    $site_name = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $site_name);
                    $site_name = substr($site_name, 0, 100);
                    $output->writeln('site_name: '.$site_name);

                    // site_pic
                    $site_pic = $service->cp;
                    $site_pic = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $site_pic);
                    $site_pic = substr($site_pic, 0, 100);
                    $output->writeln('site_pic: '.$site_pic);

                    // site_address
                    $site_address = $service->alamat;
                    $site_address = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $site_address);
                    $site_address = substr($site_address, 0, 100);
                    $output->writeln('site_address: '.$site_address);

                    // site_phone_number
                    $site_phone_number = $service->telp;
                    $site_phone_number = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $site_phone_number);
                    $site_phone_number = substr($site_phone_number, 0, 100);
                    $output->writeln('site_phone_number: '.$site_phone_number);

                    // site_email
                    $site_email = $service->email;
                    $site_email = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $site_email);
                    $site_email = substr($site_email, 0, 100);
                    $output->writeln('site_email: '.$site_email);

                    $values = [
                        'uuid' => $uuid,
                        'sid' => $sid,

                        'product_id' => null,
                        'ar_invoice_item_category_id' => $ar_invoice_item_category_id,

                        'product_name' => $product_name,
                        'product_price' => $product_price,
                        'product_price_usd' => 0,
                        'product_price_sgd' => 0,

                        'enterprise_billing_date' => $enterprise_billing_date,
                        'billing_time' => $billing_time,
                        'billing_cycle' => $billing_cycle,

                        'active' => $active,
                        'tax' => $tax,
                        'qrcode' => $qrcode,

                        'ar_invoice_faktur_id' => $ar_invoice_faktur_id,

                        'receiver_name' => $receiver_name,
                        'receiver_attention' => $receiver_attention,
                        'receiver_address' => $receiver_address,
                        'receiver_phone_number' => $receiver_phone_number,
                        'receiver_email' => null,

                        'site_name' => $site_name,
                        'site_pic' => $site_pic,
                        'site_address' => $site_address,
                        'site_phone_number' => $site_phone_number,
                        'site_email' => $site_email,
                    ];

                    /** validating required values */
                    $validator = Validator::make($values, [
                        'uuid' => 'required',
                        'sid' => 'required',
                        'ar_invoice_item_category_id' => 'required|exists:Gmedia\IspSystem\Models\ArInvoiceItemCategory,id',
                        'product_price' => 'required|numeric',
                        'enterprise_billing_date' => 'required|date_format:Y-m-d',
                        'billing_time' => 'required|numeric',
                        'billing_cycle' => 'required|numeric',
                    ], [
                        'uuid.required' => 'A :attribute is required.',
                        'sid.required' => 'A :attribute is required.',

                        'ar_invoice_item_category_id.exists' => 'Category not found.',
                        'ar_invoice_item_category_id.required' => 'A category is required.',

                        'product_price.required' => 'A product price is required.',
                        'product_price.numeric' => 'A :attribute must be numeric.',

                        'enterprise_billing_date.required' => 'A enterprise billing date is required.',
                        'enterprise_billing_date.date_format' => 'Invalid :attribute.',

                        'billing_time.required' => 'A :attribute is required.',
                        'billing_time.numeric' => 'A :attribute must be numeric.',

                        'billing_cycle.required' => 'A :attribute is required.',
                        'billing_cycle.numeric' => 'A :attribute must be numeric.',
                    ]);

                    if ($validator->fails()) {
                        array_push($migration_issue, $validator->errors()->all());
                        $output->writeln('migration_issue: '.json_encode($migration_issue));

                        DB::connection($conn)
                            ->table('gmd_finance_customer_service')
                            ->where('id', $service->id)
                            ->update(['migration_issue' => json_encode($migration_issue)]);

                        return true;
                    }

                    /** saving values */
                    $new_customer_product = $new_customer->customer_products()->where('uuid', $uuid)->first();

                    if ($new_customer_product) {
                        $id = $new_customer_product->id;

                        $validator = Validator::make($values, [
                            'uuid' => [
                                Rule::unique('customer_product')->where(function ($query) use ($uuid, $id) {
                                    return $query->where([
                                        ['uuid', '=', $uuid],
                                        ['id', '<>', $id],
                                    ]);
                                }),
                            ],
                            'sid' => [
                                Rule::unique('customer_product')->where(function ($query) use ($sid, $id) {
                                    return $query->where([
                                        ['sid', '=', $sid],
                                        ['id', '<>', $id],
                                    ]);
                                }),
                            ],
                        ], [
                            'uuid.unique' => 'The :attribute must be unused.',
                            'sid.unique' => 'The :attribute must be unused.',
                        ]);

                        if ($validator->fails()) {
                            array_push($migration_issue, $validator->errors()->all());
                            array_push($migration_issue, ['id' => $id]);

                            $output->writeln('migration_issue: '.json_encode($migration_issue));

                            DB::connection($conn)
                                ->table('gmd_finance_customer_service')
                                ->where('id', $service->id)
                                ->update(['migration_issue' => json_encode($migration_issue)]);

                            return;
                        }

                        $new_customer_product->update($values);
                    } else {
                        $validator = Validator::make($values, [
                            'uuid' => 'unique:Gmedia\IspSystem\Models\CustomerProduct,uuid',
                            'sid' => 'unique:Gmedia\IspSystem\Models\CustomerProduct,sid',
                        ], [
                            'uuid.unique' => 'The :attribute must be unused.',
                            'sid.unique' => 'The :attribute must be unused.',
                        ]);

                        if ($validator->fails()) {
                            array_push($migration_issue, $validator->errors()->all());
                            $output->writeln('migration_issue: '.json_encode($migration_issue));

                            DB::connection($conn)
                                ->table('gmd_finance_customer_service')
                                ->where('id', $service->id)
                                ->update(['migration_issue' => json_encode($migration_issue)]);

                            return;
                        }

                        $new_customer_product = $new_customer->customer_products()->create($values);
                    }

                    if ($new_customer_product) {
                        // getting invoice increment
                        $last_invoice_number = DB::connection($conn)
                            ->table('gmd_finance_invoice_customer')
                            ->where('service_id', $service->service_id)
                            ->orderByDesc('id')
                            ->value('no_invoice');

                        if ($last_invoice_number) {
                            $last_segment = explode('/', $last_invoice_number);

                            if (array_key_exists(2, $last_segment)) {
                                $string_increment = explode('.', $last_segment[2]);

                                if (array_key_exists(0, $string_increment)) {
                                    $increment = intval($string_increment[0]);

                                    if ($increment > $invoice_increment) {
                                        $invoice_increment = $increment;
                                    }
                                }
                            }
                        }

                        // additional
                        DB::connection($conn)
                            ->table('gmd_finance_customer_service_add')
                            ->where('service_id', $service->service_id)
                            ->get()
                            ->each(function ($service_add) use ($new_customer_product, $conn, $output) {
                                // uuid
                                $uuid = $service_add->uuid;
                                $output->writeln('uuid: '.$uuid);

                                if (! $uuid) {
                                    do {
                                        $uuid = Uuid::uuid4();
                                    } while (
                                        CustomerProduct::where('uuid', $uuid)->exists()
                                        or DB::connection($conn)->table('gmd_finance_customer_service_add')->where('uuid', $uuid)->exists()
                                    );

                                    DB::connection($conn)
                                        ->table('gmd_finance_customer_service_add')
                                        ->where('id', $service_add->id)
                                        ->update(['uuid' => $uuid]);
                                }

                                $migration_issue = [];

                                /** clearing resources */
                                DB::connection($conn)
                                    ->table('gmd_finance_customer_service_add')
                                    ->where('id', $service_add->id)
                                    ->update(['migration_issue' => null]);

                                /** collecting resources */

                                // ar_invoice_item_category_id
                                // additional_price
                                $ar_invoice_item_category_id = null;
                                $additional_price = 0;

                                if ($service_add->aplikasi && $service_add->aplikasi > 0) {
                                    $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Aplikasi')->value('id');
                                    $additional_price = $service_add->aplikasi;
                                }

                                if ($service_add->lain2 && $service_add->lain2 > 0) {
                                    $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Lain-Lain')->value('id');
                                    $additional_price = $service_add->lain2;
                                }

                                if ($service_add->perangkat && $service_add->perangkat > 0) {
                                    $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Manage Service')->value('id');
                                    $additional_price = $service_add->perangkat;
                                }

                                if ($service_add->instalasi && $service_add->instalasi > 0) {
                                    $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Instalasi')->value('id');
                                    $additional_price = $service_add->instalasi;
                                }

                                if ($service_add->colo && $service_add->colo > 0) {
                                    $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Data Center')->value('id');
                                    $additional_price = $service_add->colo;
                                }

                                if ($service_add->bw && $service_add->bw > 0) {
                                    $ar_invoice_item_category_id = ArInvoiceItemCategory::where('name', 'Bandwidth')->value('id');
                                    $additional_price = $service_add->bw;
                                }

                                $output->writeln('ar_invoice_item_category_id: '.$ar_invoice_item_category_id);
                                $output->writeln('additional_price: '.$additional_price);

                                // additional_name
                                $additional_name = $service_add->description;
                                $additional_name = preg_replace("/[^A-Za-z0-9&,:;!?@#%='_\/\.\-\+\(\)\*\s]/i", '', $additional_name);
                                $additional_name = substr($additional_name, 0, 75);
                                $output->writeln('additional_name: '.$additional_name);

                                $values = [
                                    'uuid' => $uuid,

                                    'product_additional_id' => null,
                                    'ar_invoice_item_category_id' => $ar_invoice_item_category_id,

                                    'additional_name' => $additional_name,
                                    'additional_price' => $additional_price,
                                    'additional_price_usd' => 0,
                                    'additional_price_sgd' => 0,
                                ];

                                /** validating required values */
                                $validator = Validator::make($values, [
                                    'uuid' => 'required',
                                    'ar_invoice_item_category_id' => 'required|exists:Gmedia\IspSystem\Models\ArInvoiceItemCategory,id',
                                    'additional_price' => 'required|numeric',
                                ], [
                                    'uuid.required' => 'A :attribute is required.',

                                    'ar_invoice_item_category_id.exists' => 'Category not found.',
                                    'ar_invoice_item_category_id.required' => 'A category is required.',

                                    'additional_price.required' => 'A additional price is required.',
                                    'additional_price.numeric' => 'A :attribute must be numeric.',
                                ]);

                                if ($validator->fails()) {
                                    array_push($migration_issue, $validator->errors()->all());
                                    $output->writeln('migration_issue: '.json_encode($migration_issue));

                                    DB::connection($conn)
                                        ->table('gmd_finance_customer_service_add')
                                        ->where('id', $service_add->id)
                                        ->update(['migration_issue' => json_encode($migration_issue)]);

                                    return;
                                }

                                /** saving values */
                                $new_customer_product_additional = $new_customer_product->customer_product_additionals()->where('uuid', $uuid)->first();

                                if ($new_customer_product_additional) {
                                    $id = $new_customer_product_additional->id;

                                    $validator = Validator::make($values, [
                                        'uuid' => [
                                            Rule::unique('customer_product_additional')->where(function ($query) use ($uuid, $id) {
                                                return $query->where([
                                                    ['uuid', '=', $uuid],
                                                    ['id', '<>', $id],
                                                ]);
                                            }),
                                        ],
                                    ], [
                                        'uuid.unique' => 'The :attribute must be unused.',
                                    ]);

                                    if ($validator->fails()) {
                                        array_push($migration_issue, $validator->errors()->all());
                                        array_push($migration_issue, ['id' => $id]);

                                        $output->writeln('migration_issue: '.json_encode($migration_issue));

                                        DB::connection($conn)
                                            ->table('gmd_finance_customer_service_add')
                                            ->where('id', $service_add->id)
                                            ->update(['migration_issue' => json_encode($migration_issue)]);

                                        return;
                                    }

                                    $new_customer_product_additional->update($values);
                                } else {
                                    $validator = Validator::make($values, [
                                        'uuid' => 'unique:Gmedia\IspSystem\Models\CustomerProductAdditional,uuid',
                                    ], [
                                        'uuid.unique' => 'The :attribute must be unused.',
                                    ]);

                                    if ($validator->fails()) {
                                        array_push($migration_issue, $validator->errors()->all());
                                        $output->writeln('migration_issue: '.json_encode($migration_issue));

                                        DB::connection($conn)
                                            ->table('gmd_finance_customer_service_add')
                                            ->where('id', $service_add->id)
                                            ->update(['migration_issue' => json_encode($migration_issue)]);

                                        return;
                                    }

                                    $new_customer_product_additional = $new_customer_product->customer_product_additionals()->create($values);
                                }
                            });

                        // payment
                        $payments = explode(',', $service->payment_to);

                        collect($payments)->each(function ($payment) use (
                            $new_customer_product,
                            $branch
                        ) {
                            $cash_bank = CashBank::where('branch_id', $branch->id)
                                ->where('erp1_id', $payment)
                                ->first();

                            if (! $cash_bank) {
                                return true;
                            }

                            $new_payment = $new_customer_product->customer_product_payments()
                                ->where('cash_bank_id', $cash_bank->id)
                                ->first();

                            if (! $new_payment) {
                                $new_payment = $new_customer_product->customer_product_payments()
                                    ->create(['cash_bank_id' => $cash_bank->id]);
                            }
                        });
                    }
                });
        }
        $new_customer->update(['invoice_increment' => $invoice_increment]);
    }

    public static function migrateCustomerYogyakarta()
    {
        $log = applog('erp, erp1__fac, migrate_customer_yogyakarta');
        $log->save('debug');

        foreach (DB::connection('erp1')
            ->table('gmd_finance_customer')
            ->cursor() as $customer) {
            /** Branch */
            $branch_name = null;
            $company_name = null;

            switch ($customer->branch) {
                case 12:
                    $branch_name = 'Yogyakarta';
                    $company_name = 'PT Media Sarana Data';
                    break;

                case 5:
                    $branch_name = 'Purwokerto';
                    $company_name = 'PT Media Sarana Data';
                    break;

                case 4:
                    $branch_name = 'Surakarta';
                    $company_name = 'PT Media Sarana Data';
                    break;

                case 18:
                    $branch_name = 'Yogyakarta';
                    $company_name = 'PT Media Sarana Akses';
                    break;

                case 19:
                    $branch_name = 'Jakarta';
                    $company_name = 'PT Media Sarana Data';
                    break;

                case 0:
                    // PT Media Sarana Data
                    if (Str::startsWith($customer->customer_id, '01.')) {
                        $branch_name = 'Yogyakarta';
                        $company_name = 'PT Media Sarana Data';
                    } elseif (Str::startsWith($customer->customer_id, '04.')) {
                        $branch_name = 'Surakarta';
                        $company_name = 'PT Media Sarana Data';
                    } elseif (Str::startsWith($customer->customer_id, '05.')) {
                        $branch_name = 'Purwokerto';
                        $company_name = 'PT Media Sarana Data';
                    }
                    // PT Media Sarana Akses
                    elseif (Str::startsWith($customer->customer_id, '001-')) {
                        $branch_name = 'Yogyakarta';
                        $company_name = 'PT Media Sarana Akses';
                    }

                    // branch = 0
                    // and customer_id not like '01.%'
                    // and customer_id is not null
                    // and customer_id != ''
                    // and customer_id != '0'
                    // and customer_id not like '04.%'
                    // and customer_id not like '05.%'
                    // and customer_id not like '04.%'
                    // and customer_id not like '001-%'

                    // not filtered:
                    // 001.IST-01
                    // 998877
                    // 226226226
                    // 001.0286.1213
                    // 01,0443,0715.MAX
                    break;
            }

            if (! $branch_name) {
                continue;
            }

            $regional_query = Regional::select(
                'regional.id',
                'company.name as company_name',
            )
                ->leftJoin('company', 'company.id', '=', 'regional.company_id');

            $branch = Branch::select(
                'branch.id',
                'branch.name',
                'branch.regional_id',
            )
                ->with([
                    'regional',
                    'regional.company',
                ])
                ->leftJoinSub($regional_query, 'regional', function ($join) {
                    $join->on('regional.id', '=', 'branch.regional_id');
                })
                ->where('branch.name', $branch_name)
                ->where('regional.company_name', $company_name)
                ->first();

            /** Category */
            $category = null;

            switch ($customer->kategori) {
                case 16:
                    $category = CustomerCategory::where('name', 'CORPORATE')->first();
                    break;

                    // case :
                //     $category = CustomerCategory::where('name', 'EDUCATION')->first();
                //     break;

                case 78:
                    $category = CustomerCategory::where('name', 'EKSKLUSIF')->first();
                    break;

                case 101:
                    $category = CustomerCategory::where('name', 'FASILITAS KANTOR')->first();
                    break;

                case 34:
                    $category = CustomerCategory::where('name', 'GAME ONLINE')->first();
                    break;

                    // case :
                //     $category = CustomerCategory::where('name', 'GOVERNMENT')->first();
                //     break;

                case 67:
                    $category = CustomerCategory::where('name', 'HOTEL')->first();
                    break;

                case 15:
                    $category = CustomerCategory::where('name', 'INSTANSI PEMERINTAH')->first();
                    break;

                case 73:
                    $category = CustomerCategory::where('name', 'ISP')->first();
                    break;

                case 351:
                    $category = CustomerCategory::where('name', 'KAFE')->first();
                    break;

                case 103:
                    $category = CustomerCategory::where('name', 'MAXI')->first();
                    break;

                case 33:
                    $category = CustomerCategory::where('name', 'PERSONAL')->first();
                    break;

                case 14:
                    $category = CustomerCategory::where('name', 'SEKOLAH')->first();
                    break;

                case 78:
                    $category = CustomerCategory::where('name', 'UNIVERSITAS / AKADEMI')->first();
                    break;

                    // case :
                //     $category = CustomerCategory::where('name', 'RESTAURANT')->first();
                //     break;

                    // case :
                //     $category = CustomerCategory::where('name', 'REST')->first();
                //     break;

                case 13:
                    $category = CustomerCategory::where('name', 'WARNET')->first();
                    break;
            }

            /** Execute migraton */
            static::migrateCustomer($customer, 'erp1', $branch, $category);
        }
    }

    public static function migrateCustomerBali()
    {
        $log = applog('erp, erp1__fac, migrate_customer_bali');
        $log->save('debug');

        foreach (DB::connection('erp1_2nd')->table('gmd_finance_customer')->cursor() as $customer) {
            /** Branch */
            $branch_name = null;
            $company_name = null;

            switch ($customer->branch) {
                case 11:
                    $branch_name = 'Bali';
                    $company_name = 'PT Media Sarana Data';
                    break;

                case 13:
                    $branch_name = 'Mataram';
                    $company_name = 'PT Media Sarana Data';
                    break;

                case 14:
                    $branch_name = 'Malang';
                    $company_name = 'PT Media Sarana Data';
                    break;

                case 15:
                    $branch_name = 'Surabaya';
                    $company_name = 'PT Media Sarana Data';
                    break;
            }

            if (! $branch_name) {
                continue;
            }

            $regional_query = Regional::select(
                'regional.id',
                'company.name as company_name',
            )
                ->leftJoin('company', 'company.id', '=', 'regional.company_id');

            $branch = Branch::select(
                'branch.id',
                'branch.name',
                'branch.regional_id',
            )
                ->with([
                    'regional',
                    'regional.company',
                ])
                ->leftJoinSub($regional_query, 'regional', function ($join) {
                    $join->on('regional.id', '=', 'branch.regional_id');
                })
                ->where('branch.name', $branch_name)
                ->where('regional.company_name', $company_name)
                ->first();

            /** Category */
            $category = null;

            switch ($customer->kategori) {
                case 16:
                    $category = CustomerCategory::where('name', 'CORPORATE')->first();
                    break;

                case 14:
                    $category = CustomerCategory::where('name', 'EDUCATION')->first();
                    break;

                case 78:
                    $category = CustomerCategory::where('name', 'EKSKLUSIF')->first();
                    break;

                case 101:
                    $category = CustomerCategory::where('name', 'FASILITAS KANTOR')->first();
                    break;

                case 34:
                    $category = CustomerCategory::where('name', 'GAME ONLINE')->first();
                    break;

                case 15:
                    $category = CustomerCategory::where('name', 'GOVERNMENT')->first();
                    break;

                case 67:
                    $category = CustomerCategory::where('name', 'HOTEL')->first();
                    break;

                    // case :
                //     $category = CustomerCategory::where('name', 'INSTANSI PEMERINTAH')->first();
                //     break;

                case 73:
                    $category = CustomerCategory::where('name', 'ISP')->first();
                    break;

                    // case :
                //     $category = CustomerCategory::where('name', 'KAFE')->first();
                //     break;

                case 103:
                    $category = CustomerCategory::where('name', 'MAXI')->first();
                    break;

                case 33:
                    $category = CustomerCategory::where('name', 'PERSONAL')->first();
                    break;

                    // case :
                //     $category = CustomerCategory::where('name', 'SEKOLAH')->first();
                //     break;

                case 79:
                    $category = CustomerCategory::where('name', 'UNIVERSITAS / AKADEMI')->first();
                    break;

                case 233:
                    $category = CustomerCategory::where('name', 'RESTAURANT')->first();
                    break;

                    // case :
                //     $category = CustomerCategory::where('name', 'REST')->first();
                //     break;

                case 13:
                    $category = CustomerCategory::where('name', 'WARNET')->first();
                    break;
            }

            /** Execute migraton */
            static::migrateCustomer($customer, 'erp1_2nd', $branch, $category);
        }
    }
}
