<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_customer_ar_invoice_id_foreign');
        });

        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('cascade');
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
            $table->dropForeign('ar_invoice_customer_ar_invoice_id_foreign');
        });

        Schema::table('ar_invoice_customer', function (Blueprint $table) {
            $table->foreign('ar_invoice_id')->references('id')->on('ar_invoice')->onDelete('set null');
        });
    }
}
