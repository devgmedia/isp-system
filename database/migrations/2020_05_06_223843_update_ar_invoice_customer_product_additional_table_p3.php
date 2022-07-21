<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductAdditionalTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('ar_inv_cus_pro_add_ar_inv_sch_cus_pro_add_id_foreign');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->dropColumn('ar_invoice_scheme_customer_product_additional_id');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_customer_product_id')->nullable()->default(null)->change();
            $table->foreign(
                'ar_invoice_customer_product_id',
                'ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign',
            )->references('id')->on('ar_invoice_customer_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_customer_product_additional_id')->nullable()->default(null);

            $table->foreign(
                'ar_invoice_scheme_customer_product_additional_id',
                'ar_inv_cus_pro_add_ar_inv_sch_cus_pro_add_id_foreign',
            )->references('id')->on('ar_invoice_scheme_customer_product_additional')->onDelete('set null');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign');
        });

        Schema::table('ar_invoice_customer_product_additional', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_customer_product_id')->nullable(false)->change();
            $table->foreign(
                'ar_invoice_customer_product_id',
                'ar_inv_cus_pro_add_ar_inv_cus_pro_id_foreign',
            )->references('id')->on('ar_invoice_customer_product')->onDelete('cascade');
        });
    }
}
