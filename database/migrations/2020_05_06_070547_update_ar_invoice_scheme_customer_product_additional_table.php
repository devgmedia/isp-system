<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceSchemeCustomerProductAdditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_scheme_customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('ar_inv_sch_cus_pro_add_ar_inv_sch_cus_pro_id_foreign');
            $table->dropForeign('ar_inv_sch_cus_pro_add_cus_pro_add_id_foreign');
        });

        Schema::table('ar_invoice_scheme_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_customer_product_id')->nullable()->default(null)->change();
            $table->foreign(
                'ar_invoice_scheme_customer_product_id',
                'ar_inv_sch_cus_pro_add_ar_inv_sch_cus_pro_id_foreign',
            )->references('id')->on('ar_invoice_scheme_customer_product')->onDelete('set null');

            $table->unsignedBigInteger('customer_product_additional_id')->nullable()->default(null)->change();
            $table->foreign(
                'customer_product_additional_id',
                'ar_inv_sch_cus_pro_add_cus_pro_add_id_foreign',
            )->references('id')->on('customer_product_additional')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_scheme_customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('ar_inv_sch_cus_pro_add_ar_inv_sch_cus_pro_id_foreign');
            $table->dropForeign('ar_inv_sch_cus_pro_add_cus_pro_add_id_foreign');
        });

        Schema::table('ar_invoice_scheme_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_customer_product_id')->nullable(false)->change();
            $table->foreign(
                'ar_invoice_scheme_customer_product_id',
                'ar_inv_sch_cus_pro_add_ar_inv_sch_cus_pro_id_foreign',
            )->references('id')->on('ar_invoice_scheme_customer_product')->onDelete('cascade');

            $table->unsignedBigInteger('customer_product_additional_id')->nullable(false)->change();
            $table->foreign(
                'customer_product_additional_id',
                'ar_inv_sch_cus_pro_add_cus_pro_add_id_foreign',
            )->references('id')->on('customer_product_additional')->onDelete('cascade');
        });
    }
}
