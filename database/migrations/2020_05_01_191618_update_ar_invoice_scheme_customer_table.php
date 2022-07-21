<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceSchemeCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_scheme_customer_ar_invoice_scheme_id_foreign');
            $table->dropForeign('ar_invoice_scheme_customer_customer_id_foreign');
        });

        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_id')->nullable(false)->change();
            $table->unsignedBigInteger('customer_id')->nullable(false)->change();

            $table->unique(['customer_id', 'ar_invoice_scheme_id'], 'ar_inv_sch_cus_cus_id_ar_inv_sch_id_unique');
        });

        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {
            $table->foreign('ar_invoice_scheme_id')->references('id')->on('ar_invoice_scheme')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_scheme_customer_ar_invoice_scheme_id_foreign');
            $table->dropForeign('ar_invoice_scheme_customer_customer_id_foreign');
        });

        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_scheme_id')->nullable()->default(null)->change();
            $table->unsignedBigInteger('customer_id')->nullable()->default(null)->change();

            $table->dropUnique('ar_inv_sch_cus_cus_id_ar_inv_sch_id_unique');
        });

        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {
            $table->foreign('ar_invoice_scheme_id')->references('id')->on('ar_invoice_scheme')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
        });
    }
}
