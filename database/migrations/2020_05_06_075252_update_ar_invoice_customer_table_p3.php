<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->string('customer_cid')->nullable()->default(null)->change();
            $table->string('customer_name')->nullable()->default(null)->change();
        });

        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_customer_ar_invoice_id_foreign');
        });

        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_id')->nullable()->default(null)->change();
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
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
            $table->string('customer_cid')->nullable(false)->change();
            $table->string('customer_name')->nullable(false)->change();
        });

        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_customer_ar_invoice_id_foreign');
        });

        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_id')->nullable(false)->change();
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('cascade');
        });
    }
}
