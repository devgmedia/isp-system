<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceSchemeCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_scheme_customer_product', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_scheme_customer_product_inv_sch_cus_id_foreign');
            $table->dropForeign('ar_invoice_scheme_customer_product_customer_product_id_foreign');
        });

        Schema::table('ar_invoice_scheme_customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_customer_id')->nullable(FALSE)->change();
            $table->unsignedBigInteger('customer_product_id')->nullable(FALSE)->change();       

            $table->unique('customer_product_id');     
        });

        Schema::table('ar_invoice_scheme_customer_product', function (Blueprint $table) {
            $table->foreign(
                'ar_invoice_scheme_customer_id',
                'ar_invoice_scheme_customer_product_ar_inv_sch_cus_id_foreign',
            )
                ->references('id')
                ->on('ar_invoice_scheme_customer')
                ->onDelete('cascade');

            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_scheme_customer_product', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_scheme_customer_product_ar_inv_sch_cus_id_foreign');
            $table->dropForeign('ar_invoice_scheme_customer_product_customer_product_id_foreign');
        });

        Schema::table('ar_invoice_scheme_customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_customer_id')->nullable()->default(NULL)->change();
            $table->unsignedBigInteger('customer_product_id')->nullable()->default(NULL)->change();       

            $table->dropUnique('ar_invoice_scheme_customer_product_customer_product_id_unique');     
        });

        Schema::table('ar_invoice_scheme_customer_product', function (Blueprint $table) {
            $table->foreign(
                'ar_invoice_scheme_customer_id',
                'ar_invoice_scheme_customer_product_inv_sch_cus_id_foreign',
            )
                ->references('id')
                ->on('ar_invoice_scheme_customer')
                ->onDelete('set null');

            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
        });
    }
}
