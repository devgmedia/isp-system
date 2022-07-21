<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceSchemeCustomerTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_scheme_customer_ar_invoice_scheme_id_foreign');
            $table->dropForeign('ar_invoice_scheme_customer_customer_id_foreign');
        });

        Schema::table('ar_invoice_scheme_customer', function (Blueprint $table) {            
            $table->unsignedBigInteger('ar_invoice_scheme_id')->nullable()->default(null)->change();
            $table->foreign('ar_invoice_scheme_id')->references('id')->on('ar_invoice_scheme')->onDelete('set null');

            $table->unsignedBigInteger('customer_id')->nullable()->default(null)->change();
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('set null');
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
            $table->unsignedBigInteger('ar_invoice_scheme_id')->nullable(false)->change();      
            $table->foreign('ar_invoice_scheme_id')->references('id')->on('ar_invoice_scheme')->onDelete('cascade');

            $table->unsignedBigInteger('customer_id')->nullable(false)->change();
            $table->foreign('customer_id')->references('id')->on('customer')->onDelete('cascade');
        });
    }
}
