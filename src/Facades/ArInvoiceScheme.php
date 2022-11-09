<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ArInvoiceScheme as ArInvoiceSchemeModel;
use Gmedia\IspSystem\Models\ArInvoiceSchemeCustomer;
use Gmedia\IspSystem\Models\ArInvoiceSchemeCustomerProduct;
use Gmedia\IspSystem\Models\ArInvoiceSchemeCustomerProductAdditional;
use Gmedia\IspSystem\Models\Customer;
use Gmedia\IspSystem\Models\CustomerProduct;
use Gmedia\IspSystem\Models\CustomerProductAdditional;

class ArInvoiceScheme
{
    public static function createCustomerScheme(Customer $customer)
    {
        $log = applog('erp, ar_invoice_scheme__fac, create_customer_scheme');
        $log->save('debug');

        $customer->load([
            'customer_products',
        ]);

        $customer->customer_products->each(function ($customer_product) {
            static::createProductScheme($customer_product);
        });
    }

    public static function updateCustomerScheme(Customer $customer)
    {
        $log = applog('erp, ar_invoice_scheme__fac, update_customer_scheme');
        $log->save('debug');

        $customer->customer_products->each(function ($customer_product) {
            static::updateProductScheme($customer_product);
        });
    }

    public static function deleteCustomerScheme(Customer $customer)
    {
        $log = applog('erp, ar_invoice_scheme__fac, delete_customer_scheme');
        $log->save('debug');

        $customer->customer_products->each(function ($customer_product) {
            static::deleteProductScheme($customer_product);
        });

        $customer->invoice_scheme_pays()->delete();
        $customer->invoice_scheme_customers()->delete();
    }

    public static function createProductScheme(
        CustomerProduct $customer_product,
        $use_additional_create_callback = false,
        $createAdditionalScheme = null
    ) {
        $log = applog('erp, ar_invoice_scheme__fac, create_product_scheme');
        $log->save('debug');

        $customer_product->load([
            'customer',
            'product',
            'customer_product_additionals',
            'customer_product_additionals.product_additional',
            'customer_product_additionals.product_additional.ar_invoice_item_category',
        ]);

        $payment_scheme_id = null;
        $name = null;

        if ($customer_product->product) {
            // payment_scheme_id
            $payment_scheme_id = $customer_product->product->payment_scheme_id;

            // name
            $name = $customer_product->product->name;
            if ($customer_product->adjusted_bandwidth) {
                $name = $name.' '.$customer_product->special_bandwidth.' '.$customer_product->product->bandwidth_unit->name;
            }
        }

        $scheme = ArInvoiceSchemeModel::create([
            'payer' => $customer_product->customer->id,
            'payment_scheme_id' => $payment_scheme_id,
            'name' => $name,

            'ignore_tax' => $customer_product->ignore_tax,
            'ignore_prorated' => $customer_product->ignore_prorated,

            'postpaid' => $customer_product->postpaid,
            'hybrid' => $customer_product->hybrid,
        ]);

        $customer_scheme = $scheme->scheme_customers()->create([
            'customer_id' => $customer_product->customer->id,
        ]);

        $customer_product_scheme = $customer_scheme->scheme_customer_products()->create([
            'customer_product_id' => $customer_product->id,
        ]);

        foreach ($customer_product->customer_product_additionals as $customer_product_additional) {
            if (
                $customer_product_additional->product_additional &&
                $customer_product_additional->product_additional->ar_invoice_item_category &&
                $customer_product_additional->product_additional->ar_invoice_item_category->name === 'Instalasi'
            ) {
                if ($use_additional_create_callback) {
                    $createAdditionalScheme($customer_product_additional);
                } else {
                    static::createAdditionalScheme($customer_product_additional);
                }
            } else {
                $customer_product_scheme->scheme_customer_product_additionals()->create([
                    'customer_product_additional_id' => $customer_product_additional->id,
                ]);
            }
        }
    }

    public static function updateProductScheme(CustomerProduct $customer_product)
    {
        $log = applog('erp, ar_invoice_scheme__fac, update_product_scheme');
        $log->save('debug');

        $scheme = $customer_product->invoice_scheme_product->scheme_customer->scheme;

        $scheme->update([
            'ignore_tax' => $customer_product->ignore_tax,
            'ignore_prorated' => $customer_product->ignore_prorated,

            'postpaid' => $customer_product->postpaid,
            'hybrid' => $customer_product->hybrid,
        ]);

        $customer_product->load([
            'customer_product_additionals',
            'customer_product_additionals.product_additional',
            'customer_product_additionals.product_additional.ar_invoice_item_category',
        ]);

        $customer_product->customer_product_additionals->each(function ($customer_product_additional) {
            if (
                $customer_product_additional->product_additional &&
                $customer_product_additional->product_additional->ar_invoice_item_category &&
                $customer_product_additional->product_additional->ar_invoice_item_category->name === 'Instalasi'
            ) {
                static::updateAdditionalScheme($customer_product_additional);
            }
        });
    }

    public static function deleteProductScheme(CustomerProduct $customer_product)
    {
        $log = applog('erp, ar_invoice_scheme__fac, delete_product_scheme');
        $log->save('debug');

        $scheme = $customer_product->invoice_scheme_product->scheme_customer->scheme;
        $scheme->delete();

        $customer_product->load([
            'customer_product_additionals',
            'customer_product_additionals.product_additional',
            'customer_product_additionals.product_additional.ar_invoice_item_category',
        ]);

        $customer_product->customer_product_additionals->each(function ($customer_product_additional) {
            if (
                $customer_product_additional->product_additional &&
                $customer_product_additional->product_additional->ar_invoice_item_category &&
                $customer_product_additional->product_additional->ar_invoice_item_category->name === 'Instalasi'
            ) {
                static::deleteAdditionalScheme($customer_product_additional);
            } else {
                $customer_product_additional->invoice_scheme_additional->delete();
            }
        });
    }

    public static function createAdditionalScheme(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, ar_invoice_scheme__fac, create_additional_scheme');
        $log->save('debug');

        $customer_product_additional->load([
            'customer_product',
            'customer_product.customer',
            'customer_product.product',
            'product_additional',
        ]);

        $payment_scheme_id = null;
        $name = null;

        if ($customer_product_additional->product_additional) {
            // payment_scheme_id
            $payment_scheme_id = $customer_product_additional->product_additional->payment_scheme_id;

            // name
            $name = $customer_product_additional->customer_product->product->name.' - '.$customer_product_additional->product_additional->name;
        }

        $scheme = ArInvoiceSchemeModel::create([
            'payer' => $customer_product_additional->customer_product->customer->id,
            'payment_scheme_id' => $payment_scheme_id,
            'name' => $name,

            'ignore_tax' => $customer_product_additional->ignore_tax,
            'hybrid' => $customer_product_additional->customer_product->hybrid,
        ]);

        $customer_scheme = $scheme->scheme_customers()->create([
            'customer_id' => $customer_product_additional->customer_product->customer->id,
        ]);

        $customer_scheme->scheme_customer_product_additionals()->create([
            'customer_product_additional_id' => $customer_product_additional->id,
        ]);
    }

    public static function updateAdditionalScheme(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, ar_invoice_scheme__fac, update_additional_scheme');
        $log->save('debug');

        $scheme = $customer_product_additional->invoice_scheme_additional->scheme_customer->scheme;

        $scheme->update([
            'ignore_tax' => $customer_product_additional->ignore_tax,
            'hybrid' => $customer_product_additional->customer_product->hybrid,
        ]);
    }

    public static function deleteAdditionalScheme(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, ar_invoice_scheme__fac, delete_additional_scheme');
        $log->save('debug');

        $scheme = $customer_product_additional->invoice_scheme_additional->scheme_customer->scheme;
        $scheme->delete();
    }

    public static function getCustomerSchemes(Customer $customer)
    {
        $log = applog('erp, ar_invoice_scheme__fac, get_customer_schemes');
        $log->save('debug');

        $schemes = collect();

        $customer->invoice_scheme_customers->each(function ($invoice_scheme_customer) use (&$schemes) {
            if ($invoice_scheme_customer->scheme) {
                $schemes->push($invoice_scheme_customer->scheme);
            }
        });
        $customer->customer_products->each(function ($customer_product) use (&$schemes) {
            $schemes->merge(static::getProductSchemes($customer_product));
        });

        $schemes = $schemes->unique('id');

        return $schemes;
    }

    public static function getProductSchemes(CustomerProduct $customer_product)
    {
        $log = applog('erp, ar_invoice_scheme__fac, get_product_schemes');
        $log->save('debug');

        $schemes = collect();

        if ($customer_product->invoice_scheme_product->scheme_customer->scheme) {
            $schemes->push($customer_product->invoice_scheme_product->scheme_customer->scheme);
        }

        $customer_product->customer_product_additionals->each(function ($customer_product_additional) use (&$schemes) {
            $schemes = $schemes->merge(static::getAdditionalSchemes($customer_product_additional));
        });

        $schemes = $schemes->unique('id');

        return $schemes;
    }

    public static function getAdditionalSchemes(CustomerProductAdditional $customer_product_additional)
    {
        $log = applog('erp, ar_invoice_scheme__fac, get_additional_schemes');
        $log->save('debug');

        $schemes = collect();

        if (
            $customer_product_additional->product_additional &&
            $customer_product_additional->product_additional->ar_invoice_item_category &&
            $customer_product_additional->product_additional->ar_invoice_item_category->name === 'Instalasi'
        ) {
            if ($customer_product_additional->invoice_scheme_additional->scheme_customer->scheme) {
                $schemes->push($customer_product_additional->invoice_scheme_additional->scheme_customer->scheme);
            }
        } else {
            if ($customer_product_additional->invoice_scheme_additional->scheme_product->scheme_customer->scheme) {
                $schemes->push($customer_product_additional->invoice_scheme_additional->scheme_product->scheme_customer->scheme);
            }
        }

        $schemes = $schemes->unique('id');

        return $schemes;
    }

    public static function removeInvalid()
    {
        $log = applog('erp, ar_invoice_scheme__fac, remove_invalid');
        $log->save('debug');

        $additional_deleted = static::removeInvalidAdditionalScheme();
        $product_deleted = static::removeInvalidProductScheme();
        $customer_deleted = static::removeInvalidCustomerScheme();

        $deleted = 0;

        foreach (ArInvoiceSchemeModel::cursor() as $scheme) {
            // hapus yang tidak ada pembayar
            $payer = $scheme->payer_ref;
            if (! $payer) {
                $scheme->delete();
                $deleted++;

                return true;
            }

            // hapus yang tidak memiliki pelanggan
            if ($scheme->scheme_customers->count() === 0) {
                $scheme->delete();
                $deleted++;

                return true;
            }
        }

        $log->new()->properties($deleted)->save('deleted');

        return $deleted === 0 && $customer_deleted === 0 && $product_deleted === 0 && $additional_deleted === 0;
    }

    public static function removeInvalidCustomerScheme()
    {
        $log = applog('erp, ar_invoice_scheme__fac, remove_invalid_customer_scheme');
        $log->save('debug');

        $deleted = 0;

        foreach (ArInvoiceSchemeCustomer::cursor() as $scheme_customer) {
            $customer = $scheme_customer->customer;
            if (! $customer) {
                $scheme_customer->delete();
                $deleted++;

                return true;
            }

            $scheme = $scheme_customer->scheme;
            if (! $scheme) {
                $scheme_customer->delete();
                $deleted++;

                return true;
            }
        }

        $log->new()->properties($deleted)->save('deleted');

        return $deleted === 0;
    }

    public static function removeInvalidProductScheme()
    {
        $log = applog('erp, ar_invoice_scheme__fac, remove_invalid_product_scheme');
        $log->save('debug');

        $deleted = 0;

        foreach (ArInvoiceSchemeCustomerProduct::cursor() as $scheme_product) {
            $customer_product = $scheme_product->customer_product;
            if (! $customer_product) {
                $scheme_product->delete();
                $deleted++;

                return true;
            }

            $scheme_customer = $scheme_product->scheme_customer;
            if (! $scheme_customer) {
                $scheme_product->delete();
                $deleted++;

                return true;
            }
        }

        $log->new()->properties($deleted)->save('deleted');

        return $deleted === 0;
    }

    public static function removeInvalidAdditionalScheme()
    {
        $log = applog('erp, ar_invoice_scheme__fac, remove_invalid_additional_scheme');
        $log->save('debug');

        $deleted = 0;

        foreach (ArInvoiceSchemeCustomerProductAdditional::cursor() as $scheme_additional) {
            $customer_product_additional = $scheme_additional->customer_product_additional;
            if (! $customer_product_additional) {
                $scheme_additional->delete();
                $deleted++;

                return true;
            }

            $scheme_product = $scheme_additional->scheme_product;
            $scheme_customer = $scheme_additional->scheme_customer;
            if (! $scheme_product && ! $scheme_customer) {
                $scheme_additional->delete();
                $deleted++;

                return true;
            }
        }

        $log->new()->properties($deleted)->save('deleted');

        return $deleted === 0;
    }

    public static function correctingInvalid()
    {
        $log = applog('erp, ar_invoice_scheme__fac, correcting_invalid');
        $log->save('debug');

        do {
            $deletedInvalid = static::removeInvalid();
        } while ($deletedInvalid);

        foreach (Customer::with([
            'customer_products',
            'customer_products.invoice_scheme_product',
            'customer_products.customer_product_additionals',
            'customer_products.customer_product_additionals.invoice_scheme_additional',
            'customer_products.customer_product_additionals.product_additional',
        ])->cursor() as $customer) {
            $customer->customer_products->each(function ($customer_product) {
                if (! $customer_product->invoice_scheme_product) {
                    static::createProductScheme($customer_product);
                }

                $customer_product->refresh();
                $customer_product->customer_product_additionals->each(function ($customer_product_additional) {
                    if (
                        $customer_product_additional->product_additional &&
                        $customer_product_additional->product_additional->ar_invoice_item_category &&
                        $customer_product_additional->product_additional->ar_invoice_item_category->name === 'Instalasi' &&
                        ! $customer_product_additional->invoice_scheme_additional
                    ) {
                        static::createAdditionalScheme($customer_product_additional);
                    }
                });
            });
        }
    }
}
