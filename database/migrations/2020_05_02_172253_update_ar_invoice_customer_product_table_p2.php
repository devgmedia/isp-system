<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_customer_product_id')->nullable()->default(null);

            $table->string('customer_product_name')->nullable()->default(null);

            $table->unsignedInteger('customer_product_price')->nullable()->default(null);
            $table->boolean('customer_product_price_include_vat')->nullable()->default(null);

            $table->unsignedBigInteger('customer_product_payment_scheme_id')->nullable()->default(null);
            $table->string('customer_product_payment_scheme_name')->nullable()->default(null);

            $table->unsignedInteger('customer_product_bandwidth')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_bandwidth_unit_id')->nullable()->default(null);
            $table->string('customer_product_bandwidth_unit_name')->nullable()->default(null);

            $table->foreign(
                'ar_invoice_scheme_customer_product_id',
                'ar_inv_cus_pro_ar_inv_sch_cus_pro_id_foreign',
            )
                ->references('id')
                ->on('ar_invoice_scheme_customer_product')
                ->onDelete('set null');

            $table->foreign(
                'customer_product_payment_scheme_id',
                'ar_inv_cus_pro_cus_pro_pay_sch_id_foreign',
            )
                ->references('id')
                ->on('payment_scheme')
                ->onDelete('set null');

            $table->foreign(
                'customer_product_bandwidth_unit_id',
                'ar_inv_cus_pro_cus_pro_ban_uni_id_foreign',
            )
                ->references('id')
                ->on('bandwidth_unit')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->dropForeign('ar_inv_cus_pro_ar_inv_sch_cus_pro_id_foreign');

            $table->dropForeign('ar_inv_cus_pro_cus_pro_pay_sch_id_foreign');
            $table->dropForeign('ar_inv_cus_pro_cus_pro_ban_uni_id_foreign');
        });

        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->dropColumn([
                'ar_invoice_scheme_customer_product_id',

                'customer_product_name',

                'customer_product_price',
                'customer_product_price_include_vat',

                'customer_product_payment_scheme_id',
                'customer_product_payment_scheme_name',

                'customer_product_bandwidth',
                'customer_product_bandwidth_unit_id',
                'customer_product_bandwidth_unit_name',
            ]);
        });
    }
}
