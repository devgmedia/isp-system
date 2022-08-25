<?php

namespace Gmedia\IspSystem\Facades;

use Carbon\Carbon;
use DivineOmega\SSHConnection\SSHConnection;
use Gmedia\IspSystem\Facades\Mail as MailFac;
use Gmedia\IspSystem\Mail\Service\AutoDisableMail;
use Gmedia\IspSystem\Mail\Service\CollectedAutoDisableMail;
use Gmedia\IspSystem\Mail\Service\CollectedNextDismantleMail;
use Gmedia\IspSystem\Mail\Service\InstallationMail;
use Gmedia\IspSystem\Models\ArInvoice;
use Gmedia\IspSystem\Models\CustomerProduct;
use Gmedia\IspSystem\Models\CustomerProductAdditional;
use Gmedia\IspSystem\Models\CustomerProductLog;
use Gmedia\IspSystem\Models\Employee;
use Gmedia\IspSystem\Models\ProductRouter;
use Gmedia\IspSystem\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;
use RouterOS\Client;
use RouterOS\Query; // tudak bisa pakai alias
use Symfony\Component\Process\Process; // tudak bisa pakai alias

class Service
{
    public static function executeAutoDisableConnections()
    {
        $log = applog('erp, service__fac, execute_auto_disable_connections');
        $log->save('debug');

        // untuk invoice yang belum dibayar
        // disable saat melewati due date
        // yang auto disable-nya on
        // yang billing-nya aktif, untuk mencegah eksekusi pelanggan yang sudah tidak aktif
        // yang service-nya aktif, untuk mencegah eksekusi pelanggan yang sudah tidak aktif

        $invoice_customer_query = DB::table('ar_invoice_customer')
            ->select(
                'ar_invoice_customer.id',
                'ar_invoice.id as invoice_id',
                'ar_invoice.uuid as invoice_uuid',
                'ar_invoice.number',
                'ar_invoice.paid',
                'ar_invoice.due_date',
                'ar_invoice.whatsapp_sent',
            )
            ->leftJoin('ar_invoice', 'ar_invoice.id', '=', 'ar_invoice_customer.ar_invoice_id');

        $invoice_customer_product_query = DB::table('ar_invoice_customer_product')
            ->select(
                'ar_invoice_customer_product.id',
                'ar_invoice_customer_product.customer_product_id',
                'ar_invoice_customer.invoice_id',
                'ar_invoice_customer.invoice_uuid',
                'ar_invoice_customer.number',
                'ar_invoice_customer.paid',
                'ar_invoice_customer.due_date',
                'ar_invoice_customer.whatsapp_sent',
            )
            ->leftJoinSub($invoice_customer_query, 'ar_invoice_customer', function ($join) {
                $join->on('ar_invoice_customer.id', '=', 'ar_invoice_customer_product.ar_invoice_customer_id');
            });

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
                'product.price',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $services_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer.name as customer_name',
                'customer.cid',
                'customer_product.sid',
                'product.name',

                DB::raw("(
                    case when
                        product.payment_scheme_name = 'Monthly'
                    then
                        case when
                            customer_product.billing_start_date is not null
                        then
                            case when
                                customer_product.billing_end_date is not null
                            then
                                (
                                    curdate() >= customer_product.billing_start_date and
                                    curdate() <= customer_product.billing_end_date
                                )
                            else
                                (curdate() >= customer_product.billing_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            customer_product.billing_date is not null
                        then
                            case when
                                product.name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= customer_product.billing_date and
                                    curdate() <= last_day(date_add(customer_product.billing_date, interval 4 month))
                                )
                            else
                                case when
                                    product.name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= customer_product.billing_date and
                                        curdate() <= last_day(date_add(customer_product.billing_date, interval 8 month))
                                    )
                                else
                                    (customer_product.billing_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as billing_is_active"),
                DB::raw("(
                    case when
                        product.payment_scheme_name = 'Monthly'
                    then
                        case when
                            customer_product.service_start_date is not null
                        then
                            case when
                                customer_product.service_end_date is not null
                            then
                                (
                                    curdate() >= customer_product.service_start_date and
                                    curdate() <= customer_product.service_end_date
                                )
                            else
                                (curdate() >= customer_product.service_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            customer_product.service_date is not null
                        then
                            case when
                                product.name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= customer_product.service_date and
                                    curdate() <= last_day(date_add(customer_product.service_date, interval 4 month))
                                )
                            else
                                case when
                                    product.name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= customer_product.service_date and
                                        curdate() <= last_day(date_add(customer_product.service_date, interval 8 month))
                                    )
                                else
                                    (customer_product.service_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as service_is_active"),

                DB::raw('(
                    case when
                        (
                            case when
                                customer_product.adjusted_price
                            then
                                customer_product.special_price
                            else
                                product.price
                            end
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as price_is_valid'),

                'customer_product.email_support_auto_disable_sent_at',
                'ar_invoice_customer_product.invoice_id',
                'ar_invoice_customer_product.invoice_uuid',
                'ar_invoice_customer_product.number as invoice_number',
            )
            ->leftJoinSub($invoice_customer_product_query, 'ar_invoice_customer_product', function ($join) {
                $join->on('ar_invoice_customer_product.customer_product_id', '=', 'customer_product.id');
            })
            ->leftJoin('customer', 'customer.id', '=', 'customer_product.customer_id')
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            })
            ->where('customer_product.auto_disable_connection', true)
            ->whereIn('customer.branch_id', [1, 2, 3, 4, 5]) // berbeda dengan query list monitoring
            ->where('ar_invoice_customer_product.paid', false)
            ->where('ar_invoice_customer_product.whatsapp_sent', true)
            ->whereRaw('ar_invoice_customer_product.due_date < curdate()') // berbeda dengan query list monitoring
            ->having('billing_is_active', true)
            ->having('service_is_active', true)
            ->having('price_is_valid', true)
            ->groupBy(
                'customer_product.id',
                'customer.name',
                'customer.cid',
                'customer_product.sid',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'customer_product.billing_date',
                'customer_product.service_start_date',
                'customer_product.service_end_date',
                'customer_product.service_date',
                'customer_product.email_support_auto_disable_sent_at',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            );

        foreach ($services_query->cursor() as $service) {
            $customer_product = CustomerProduct::find($service->id);
            $ar_invoice = ArInvoice::find($service->invoice_id);

            static::disableConnection($customer_product, $ar_invoice);

            // // Fake disable connection
            // $customer_product->update([
            //     'isolation' => true,
            //     'isolation_reference' => $ar_invoice->number,
            //     'isolation_invoice' => $ar_invoice->id,
            // ]);
        }
    }

    public static function disableConnection(CustomerProduct $service, ArInvoice $invoice = null)
    {
        $log = applog('erp, service__fac, disable_connection');
        $log->save('debug');

        $radius_username = $service->sid.$service->product->radius_username_suffix;
        $isolation_reference = null;
        $isolation_invoice = null;

        if ($invoice) {
            $isolation_reference = $invoice->number;
            $isolation_invoice = $invoice->id;
        }

        $service->update([
            'radius_username' => null,
            'radius_password' => null,

            'isolation' => true,
            'isolation_reference' => $isolation_reference,
            'isolation_invoice' => $isolation_invoice,
        ]);

        // remove radius
        Radius::deleteUser($radius_username);

        // remove pppoe
        static::removePppoe($service);

        // update payment status
        Customer::updatePaymentActiveStatus($service);
    }

    public static function enableConnection(CustomerProduct $service)
    {
        $log = applog('erp, service__fac, enable_connection');
        $log->save('debug');

        $radius_username = $service->sid.$service->product->radius_username_suffix;
        $radius_password = $service->product->radius_password_prefix.$service->sid;

        $service->update([
            'radius_username' => $radius_username,
            'radius_password' => $radius_password,

            'isolation' => false,
            'isolation_reference' => null,
            'isolation_invoice' => null,
        ]);

        // create radius
        Radius::createUser($radius_username, $radius_password);
    }

    public static function removePppoe(CustomerProduct $service)
    {
        $log = applog('erp, service__fac, remove_pppoe');
        $log->save('debug');

        $service->load([
            'product',
            'product.routers',
            'product.routers.os',
        ]);

        $number_removed = 0;
        $radius_username = $service->sid.$service->product->radius_username_suffix;

        $log->new()->properties($service->product->routers)->save('checking on router list');
        $service->product->routers->each(function ($router) use (&$number_removed, $radius_username) {
            if ($router->os) {
                switch ($router->os->name) {
                    case 'Mikrotik':
                        if (static::removeMikrotikPppoe($router, $radius_username)) {
                            $number_removed++;
                        }
                        break;

                    case 'VyOS':
                        if (static::removeVyosPppoe($router, $radius_username)) {
                            $number_removed++;
                        }
                        break;
                }
            }
        });

        $log->save('removing '.$number_removed.' PPPoE');

        return $number_removed;
    }

    public static function removeMikrotikPppoe(ProductRouter $router, $radius_username)
    {
        $log = applog('erp, service__fac, remove_mikrotik_pppoe');
        $log->save('debug');

        $log->save('trying to connect to the '.$router->host);

        $client = new Client([
            'host' => $router->host,
            'user' => $router->user,
            'pass' => $router->pass,
            'port' => (int) $router->port,
        ]);

        $log->save('connected to the '.$router->host);

        // find
        $query = (new Query('/interface/pppoe-server/print'))
            ->where('user', $radius_username);
        $response = $client->qr($query);
        $pppoes = collect($response);

        if ($pppoes->isEmpty()) {
            return false;
        }

        $pppoe = $pppoes->first();
        $pppoe_id = $pppoe['.id'];

        // remove
        $query = (new Query('/interface/pppoe-server/remove'))
            ->equal('.id', $pppoe_id);
        $client->qr($query);

        return true;
    }

    public static function removeVyosPppoe(ProductRouter $router, $radius_username)
    {
        $log = applog('erp, service__fac, remove_vyos_pppoe');
        $log->save('debug');

        $log->new()->properties($radius_username)->save('username');
        $log->new()->properties($router->host)->save('host');

        $vyos_script = config('app.auto_disable_vyos_script');
        if (! $vyos_script) {
            return false;
        }

        $python_process = config('app.python_process');
        if (! $python_process) {
            return false;
        }

        $process = new Process(
            $python_process.' '.
            $vyos_script.' '.
            $router->host.' '.
            $router->user.' '.
            $router->pass.' '.
            $router->port.' '.
            $radius_username
        );

        $process->run();

        if (! $process->isSuccessful()) {
            $log->save('failed to execute');
            $log->new()->properties($process->getErrorOutput())->save('error output');

            return false;
        }

        $log->new()->properties($process->getOutput())->save('output');

        return true;
    }

    public static function removeVyosPppoeWithDivineOmega(ProductRouter $router, $radius_username)
    {
        $log = applog('erp, service__fac, remove_vyos_pppoe_with_divine_omega');
        $log->save('debug');

        $log->new()->properties($radius_username)->save('username');
        $log->new()->properties($router->host)->save('host');

        $connection = (new SSHConnection())
            ->to($router->host)
            ->onPort($router->port)
            ->as($router->user)
            ->withPassword($router->pass)
            ->connect();

        $command = $connection->run('reset pppoe-server username "'.$radius_username.'"');

        $output = $command->getOutput();
        $log->new()->properties($output)->save('output');

        $error = $command->getError();
        if ($error) {
            $log->new()->properties($error)->save('error');

            return false;
        }

        return true;
    }

    public static function removeVyosPppoeWithPhpSecLib2(ProductRouter $router, $radius_username)
    {
        $log = applog('erp, service__fac, remove_vyos_pppoe_with_php_sec_lib_2');
        $log->save('debug');

        $log->new()->properties($radius_username)->save('username');
        $log->new()->properties($router->host)->save('host');

        // $key = new RSA();
        // $key->loadKey(file_get_contents(config('app.private_key')));

        // $ssh = new SSH2($router->host, $router->port);
        // if (!$ssh->login($router->user, $key)) {
        //     $log->save('login failed');
        // }

        $ssh = new SSH2($router->host, $router->port);
        $result = $ssh->login($router->user, [
            ['Password' => $router->pass],
        ]);
        if (! $result) {
            $log->save('login failed');
        }

        $output = $ssh->exec('reset pppoe-server username "'.$radius_username.'"');
        $log->new()->properties($output)->save('output');

        return true;
    }

    public static function updateIsolation(ArInvoice $ar_invoice)
    {
        $log = applog('erp, service__fac, update_isolation');
        $log->save('debug');

        $log->new()->properties($ar_invoice->number)->save('invoice number');

        $paid_all = true;
        $customer_product = null;
        $invoice_ref = null;

        $ar_invoice->load([
            'invoice_customers',

            'invoice_customers.invoice_customer_products',
            'invoice_customers.invoice_customer_products.customer_product',
            'invoice_customers.invoice_customer_products.customer_product.invoice_products',

            'invoice_customers.invoice_customer_product_additionals',
            'invoice_customers.invoice_customer_product_additionals.customer_product_additional',
            'invoice_customers.invoice_customer_product_additionals.customer_product_additional.invoice_additionals',
        ]);

        $ar_invoice->invoice_customers->each(function ($ar_invoice_customer) use (&$paid_all, &$customer_product, &$invoice_ref) {
            $ar_invoice_customer->invoice_customer_products->each(function ($ar_invoice_customer_product) use (&$paid_all, &$customer_product, &$invoice_ref) {
                $customer_product = $ar_invoice_customer_product->customer_product;
                if (! $customer_product) {
                    return true;
                }

                $customer_product->invoice_products->each(function ($invoice_product) use (&$paid_all, &$invoice_ref) {
                    if (
                        $invoice_product->invoice_customer &&
                        $invoice_product->invoice_customer->invoice &&
                        $invoice_product->invoice_customer->invoice->due_date->lt(Carbon::now()->startOfDay()) &&
                        ! $invoice_product->invoice_customer->invoice->paid
                    ) {
                        $paid_all = false;
                        $invoice_ref = $invoice_product->invoice_customer->invoice;
                    }
                });
            });

            $ar_invoice_customer->invoice_customer_product_additionals->each(function ($ar_invoice_customer_product_additional) use (&$paid_all, &$customer_product, &$invoice_ref) {
                $customer_product_additional = $ar_invoice_customer_product_additional->customer_product_additional;
                if (! $customer_product_additional) {
                    return true;
                }

                $customer_product = $customer_product_additional->customer_product;
                $paid_all = true;
                $customer_product_additional->invoice_additionals->each(function ($invoice_additional) use (&$paid_all, &$invoice_ref) {
                    if (
                        $invoice_additional->invoice_customer &&
                        $invoice_additional->invoice_customer->invoice &&
                        $invoice_additional->invoice_customer->invoice->due_date->lt(Carbon::now()->startOfDay()) &&
                        ! $invoice_additional->invoice_customer->invoice->paid
                    ) {
                        $paid_all = false;
                        $invoice_ref = $invoice_additional->invoice_customer->invoice;
                    }
                });
            });
        });

        $log->save('is paid all: '.$paid_all);

        if ($customer_product) {
            if ($paid_all) {
                static::enableConnection($customer_product);
            } else {
                static::disableConnection($customer_product, $invoice_ref);
            }
        }
    }

    public static function sendInstallationEmail(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, service__fac, send_installation_email');
        $log->save('debug');

        $to = config('services.service.retail_installation_to_mail_address');
        $cc = config('services.service.retail_installation_cc_mail_address');

        $default_mail = Mail::getSwiftMailer();
        $installation_mail = $default_mail;
        if (in_array(\FacadesApp::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $installation_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($installation_mail);

        Mail::to($to)->cc($cc)->send(new InstallationMail([
            'service' => [
                'sid' => $customer_product_additional->sid,
                'name' => $customer_product_additional->customer_product->product->name,
                'cid' => $customer_product_additional->customer_product->customer->cid,
                'customer' => $customer_product_additional->customer_product->customer->name,
                'installation_date' => $customer_product_additional->service_date->translatedFormat('d F Y'),
            ],
        ]));

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendAutoDisableConnectionNotifications()
    {
        $log = applog('erp, service__fac, send_auto_disable_connection_notifications');
        $log->save('debug');

        // untuk invoice yang belum dibayar
        // disable saat melewati due date
        // yang auto disable-nya on
        // yang billing-nya aktif, untuk mencegah eksekusi pelanggan yang sudah tidak aktif
        // yang service-nya aktif, untuk mencegah eksekusi pelanggan yang sudah tidak aktif

        $invoice_customer_query = DB::table('ar_invoice_customer')
            ->select(
                'ar_invoice_customer.id',
                'ar_invoice.id as invoice_id',
                'ar_invoice.uuid as invoice_uuid',
                'ar_invoice.number',
                'ar_invoice.paid',
                'ar_invoice.due_date',
                'ar_invoice.whatsapp_sent',
            )
            ->leftJoin('ar_invoice', 'ar_invoice.id', '=', 'ar_invoice_customer.ar_invoice_id');

        $invoice_customer_product_query = DB::table('ar_invoice_customer_product')
            ->select(
                'ar_invoice_customer_product.id',
                'ar_invoice_customer_product.customer_product_id',
                'ar_invoice_customer.invoice_id',
                'ar_invoice_customer.invoice_uuid',
                'ar_invoice_customer.number',
                'ar_invoice_customer.paid',
                'ar_invoice_customer.due_date',
                'ar_invoice_customer.whatsapp_sent',
            )
            ->leftJoinSub($invoice_customer_query, 'ar_invoice_customer', function ($join) {
                $join->on('ar_invoice_customer.id', '=', 'ar_invoice_customer_product.ar_invoice_customer_id');
            });

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
                'product.price',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $services = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer.name as customer_name',
                'customer.cid',
                'customer_product.sid',
                'product.name',

                DB::raw("(
                    case when
                        product.payment_scheme_name = 'Monthly'
                    then
                        case when
                            customer_product.billing_start_date is not null
                        then
                            case when
                                customer_product.billing_end_date is not null
                            then
                                (
                                    curdate() >= customer_product.billing_start_date and
                                    curdate() <= customer_product.billing_end_date
                                )
                            else
                                (curdate() >= customer_product.billing_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            customer_product.billing_date is not null
                        then
                            case when
                                product.name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= customer_product.billing_date and
                                    curdate() <= last_day(date_add(customer_product.billing_date, interval 4 month))
                                )
                            else
                                case when
                                    product.name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= customer_product.billing_date and
                                        curdate() <= last_day(date_add(customer_product.billing_date, interval 8 month))
                                    )
                                else
                                    (customer_product.billing_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as billing_is_active"),
                DB::raw("(
                    case when
                        product.payment_scheme_name = 'Monthly'
                    then
                        case when
                            customer_product.service_start_date is not null
                        then
                            case when
                                customer_product.service_end_date is not null
                            then
                                (
                                    curdate() >= customer_product.service_start_date and
                                    curdate() <= customer_product.service_end_date
                                )
                            else
                                (curdate() >= customer_product.service_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            customer_product.service_date is not null
                        then
                            case when
                                product.name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= customer_product.service_date and
                                    curdate() <= last_day(date_add(customer_product.service_date, interval 4 month))
                                )
                            else
                                case when
                                    product.name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= customer_product.service_date and
                                        curdate() <= last_day(date_add(customer_product.service_date, interval 8 month))
                                    )
                                else
                                    (customer_product.service_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as service_is_active"),

                DB::raw('(
                    case when
                        (
                            case when
                                customer_product.adjusted_price
                            then
                                customer_product.special_price
                            else
                                product.price
                            end
                        ) > 0
                    then
                        true
                    else
                        false
                    end
                ) as price_is_valid'),

                'customer_product.email_support_auto_disable_sent_at',
                'ar_invoice_customer_product.invoice_id',
                'ar_invoice_customer_product.invoice_uuid',
                'ar_invoice_customer_product.number as invoice_number',
            )
            ->leftJoinSub($invoice_customer_product_query, 'ar_invoice_customer_product', function ($join) {
                $join->on('ar_invoice_customer_product.customer_product_id', '=', 'customer_product.id');
            })
            ->leftJoin('customer', 'customer.id', '=', 'customer_product.customer_id')
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            })
            ->where('customer_product.auto_disable_connection', true)
            ->whereIn('customer.branch_id', [1, 2, 3, 4, 5]) // berbeda dengan query list monitoring
            ->where('ar_invoice_customer_product.paid', false)
            ->where('ar_invoice_customer_product.whatsapp_sent', true)
            ->whereRaw('ar_invoice_customer_product.due_date = date_sub(curdate(), interval 1 day)')
            ->having('billing_is_active', true)
            ->having('service_is_active', true)
            ->having('price_is_valid', true)
            ->groupBy(
                'customer_product.id',
                'customer.name',
                'customer.cid',
                'customer_product.sid',
                'customer_product.billing_start_date',
                'customer_product.billing_end_date',
                'customer_product.billing_date',
                'customer_product.service_start_date',
                'customer_product.service_end_date',
                'customer_product.service_date',
                'customer_product.email_support_auto_disable_sent_at',
                'customer_product.adjusted_price',
                'customer_product.special_price',
            )
            ->get();

        static::sendCollectedDisableConnectionEmail($services);

        $services->each(function ($service) {
            $customer_product = CustomerProduct::find($service->id);
            static::sendDisableConnectionInformationWhatsapp($customer_product, $service->invoice_uuid, $service->invoice_number);
        });
    }

    public static function sendActivationNotifications()
    {
        $log = applog('erp, service__fac, send_activation_notifications');
        $log->save('debug');

        $services_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer.name as customer_name',
                'customer.cid',
                'customer_product.sid',
                'customer_product.installation_date',
                'customer_product.whatsapp_activation_sent_at',
            )
            ->leftJoin('customer', 'customer.id', '=', 'customer_product.customer_id')
            ->where('customer_product.hybrid', true)
            ->whereNull('customer_product.whatsapp_activation_sent_at')
            ->whereMonth('customer_product.installation_date', DB::raw('month(curdate())'))
            ->whereYear('customer_product.installation_date', DB::raw('year(curdate())'))
            ->whereRaw('curdate() >= customer_product.installation_date');

        $total_services_query = clone $services_query;
        $total = DB::table(DB::raw('('.$total_services_query->toSql().') as customer_product'))
            ->select(DB::raw('count(customer_product.id) as total'))
            ->setBindings($total_services_query->getBindings())
            ->value('total');

        $log->save('total activation notifications: '.$total);

        $services = $services_query->get();
        $services->each(function ($service) {
            $customer_product = CustomerProduct::find($service->id);
            static::sendWhatsappActivation($customer_product);
        });
    }

    public static function sendDisableConnectionEmail(Collection $service, CustomerProduct $customer_product) // now, is not used
    {
        $log = applog('erp, service__fac, send_disable_connection_email');
        $log->save('debug');

        if (
            ! $customer_product->email_support_auto_disable_sent_at or
            ! $customer_product->email_support_auto_disable_sent_at->isCurrentMonth()
        ) {
            $to = config('services.service.retail_auto_disable_to_mail_address');
            $cc = config('services.service.retail_auto_disable_cc_mail_address');

            $default_mail = Mail::getSwiftMailer();
            $auto_disable_mail = $default_mail;
            if (in_array(\FacadesApp::environment(), ['development', 'testing'])) {
                $to = config('app.dev_mail_address');
                $cc = config('app.dev_cc_mail_address');
                $auto_disable_mail = MailFac::getSwiftMailer('dev');
            }
            Mail::setSwiftMailer($auto_disable_mail);

            Mail::to($to)->cc($cc)->send(new AutoDisableMail([
                'service' => $service->toArray(),
            ]));

            Mail::setSwiftMailer($default_mail);

            $customer_product->update([
                'email_support_auto_disable_sent_at' => Carbon::now()->toDateTimeString(),
            ]);
        }
    }

    public static function sendCollectedDisableConnectionEmail(Collection $services)
    {
        $log = applog('erp, service__fac, send_collected_disable_connection_email');
        $log->save('debug');

        $to = config('services.service.retail_auto_disable_to_mail_address');
        $cc = config('services.service.retail_auto_disable_cc_mail_address');

        $default_mail = Mail::getSwiftMailer();
        $auto_disable_mail = $default_mail;
        if (in_array(\FacadesApp::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $auto_disable_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($auto_disable_mail);

        Mail::to($to)->cc($cc)->send(new CollectedAutoDisableMail([
            'services' => $services->toArray(),
        ]));

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendDisableConnectionInformationWhatsapp(CustomerProduct $service, $invoice_uuid, $invoice_number)
    {
        $log = applog('erp, service__fac, send_disable_connection_information_whatsapp');
        $log->save('debug');

        $phone_numbers = collect();
        $service->customer->phone_numbers->each(function ($phone_number) use (&$phone_numbers) {
            $phone_numbers->push($phone_number->number);
        });
        $phone_numbers = $phone_numbers->all();

        if (! FacadesApp::environment('production')) {
            $dev_phone_numbers = config('app.dev_phone_numbers');

            if (FacadesApp::environment(['staging', 'development']) && $dev_phone_numbers) {
                $phone_numbers = $dev_phone_numbers;
            } else {
                return response(['message' => 'Delivery failed'], 500);
            }
        }

        $template_name = 'disable_connection_information_v2';
        $parameters = [
            [
                'type' => 'text',
                'text' => $invoice_number,
            ],
            [
                'type' => 'text',
                'text' => config('app.client_domain').'/pay'.'/'.$invoice_uuid,
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

        $success = Whatsapp::sendMultipleReceivers($template_name, null, $phone_numbers, false, $components);

        if ($success) {
            $service->update([
                'whatsapp_disable_connection_information_sent_at' => Carbon::now()->toDateTimeString(),

                'isolation_whatsapp_at' => Carbon::now()->toDateTimeString(),
                'isolation_whatsapp_by' => Employee::where('user_id', Auth::guard('api')->id())->value('id'),
            ]);
        }

        return $success;
    }

    public static function sendCollectedNextDismantleEmail(Collection $services)
    {
        $log = applog('erp, service__fac, send_collected_next_dismantle_email');
        $log->save('debug');

        $to = config('services.service.retail_dismantle_to_mail_address');
        $cc = config('services.service.retail_dismantle_cc_mail_address');

        $default_mail = Mail::getSwiftMailer();
        $dismantle_mail = $default_mail;
        if (in_array(\FacadesApp::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $dismantle_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($dismantle_mail);

        Mail::to($to)->cc($cc)->send(new CollectedNextDismantleMail([
            'services' => $services->toArray(),
        ]));

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendWhatsappActivation(CustomerProduct $customer_product)
    {
        $log = applog('erp, service__fac, send_whatsapp_activation');
        $log->save('debug');

        $phone_numbers = collect();
        $customer_product->customer->phone_numbers->each(function ($phone_number) use (&$phone_numbers) {
            $phone_numbers->push($phone_number->number);
        });
        $phone_numbers = $phone_numbers->all();

        if (! FacadesApp::environment('production')) {
            $dev_phone_numbers = config('app.dev_phone_numbers');

            if (FacadesApp::environment(['staging', 'development']) && $dev_phone_numbers) {
                $phone_numbers = $dev_phone_numbers;
            } else {
                return false;
            }
        }

        $template_name = 'activation_v2';
        $parameters = [
            [
                'type' => 'text',
                'text' => $customer_product->customer->name,
            ],
            [
                'type' => 'text',
                'text' => $customer_product->customer->cid,
            ],
            [
                'type' => 'text',
                'text' => $customer_product->customer->cid,
            ],
            [
                'type' => 'text',
                'text' => $customer_product->product->brand->customer_account_default_password,
            ],
            [
                'type' => 'text',
                'text' => 'https://youtu.be/pKFMDAuWsIY',
            ],
            [
                'type' => 'text',
                'text' => 'https://s.id/17kqW',
            ],
        ];

        $success = Whatsapp::sendMultipleReceivers($template_name, $parameters, $phone_numbers);

        if ($success) {
            $customer_product->update([
                'whatsapp_activation_sent_at' => Carbon::now()->toDateTimeString(),
            ]);

            // log
            $customer_product_log = CustomerProductLog::create([
                'title' => 'send activation whatsapp',
                'customer_product_id' => $customer_product->id,
            ]);
            $log->new()->properties($customer_product_log->id)->save('service log');
        }

        return $success;
    }

    public static function toActiveBilling($callBack)
    {
        $log = applog('erp, service__fac, to_active_billing');
        $log->save('debug');

        $billing_start_date = Carbon::now()->toImmutable();
        $billing_end_date = $billing_start_date;

        $regional_query = DB::table('regional')
            ->select(
                'regional.id',
                'regional.company_id',
            );

        $branch_query = DB::table('branch')
            ->select(
                'branch.id',
                'branch.name',
                'branch.regional_id',
                'regional.company_id',
            )
            ->leftJoinSub($regional_query, 'regional', function ($join) {
                $join->on('regional.id', '=', 'branch.regional_id');
            });

        $customer_query = DB::table('customer')
            ->select(
                'customer.id',
                'customer.uuid',
                'customer.cid',
                'customer.name',
                'customer.branch_id',
                'branch.regional_id',
                'branch.company_id',
                'branch.name as branch_name',
            )
            ->leftJoinSub($branch_query, 'branch', function ($join) {
                $join->on('branch.id', '=', 'customer.branch_id');
            });

        $product_query = DB::table('product')
            ->select(
                'product.id',
                'product.name',
                'payment_scheme.name as payment_scheme_name',
            )
            ->leftJoin('payment_scheme', 'payment_scheme.id', '=', 'product.payment_scheme_id');

        $customer_products_query = DB::table('customer_product')
            ->select(
                'customer_product.id',
                'customer_product.uuid',
                'customer_product.sid',
                'product.name as service_name',

                'customer.id as customer_id',
                'customer.uuid as customer_uuid',
                'customer.cid',
                'customer.name as customer_name',

                DB::raw("(
                    case when
                        product.payment_scheme_name = 'Monthly'
                    then
                        case when
                            customer_product.billing_start_date is not null
                        then
                            case when
                                customer_product.billing_end_date is not null
                            then
                                (
                                    curdate() >= customer_product.billing_start_date and
                                    curdate() <= customer_product.billing_end_date
                                )
                            else
                                (curdate() >= customer_product.billing_start_date)
                            end
                        else
                            false
                        end
                    else
                        case when
                            customer_product.billing_date is not null
                        then
                            case when
                                product.name like '%5 Bulan%'
                            then
                                (
                                    curdate() >= customer_product.billing_date and
                                    curdate() <= last_day(date_add(customer_product.billing_date, interval 4 month))
                                )
                            else
                                case when
                                    product.name like '%9 Bulan%'
                                then
                                    (
                                        curdate() >= customer_product.billing_date and
                                        curdate() <= last_day(date_add(customer_product.billing_date, interval 8 month))
                                    )
                                else
                                    (customer_product.billing_date = curdate())
                                end
                            end
                        else
                            false
                        end
                    end
                ) as billing_is_active"),

                'customer.branch_id',
                'customer.regional_id',
                'customer.company_id',
                'customer.branch_name',
            )
            ->leftJoinSub($customer_query, 'customer', function ($join) {
                $join->on('customer.id', '=', 'customer_product.customer_id');
            })
            ->leftJoinSub($product_query, 'product', function ($join) {
                $join->on('product.id', '=', 'customer_product.product_id');
            })
            ->whereIn('customer.branch_id', [1, 2, 3, 4, 5]); // berbeda dengan query list monitoring

        $customer_products_query->having('billing_is_active', true);

        foreach ($customer_products_query->cursor() as $service) {
            $callBack($service);
        }
    }
}
