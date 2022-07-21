<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_customer_product_ar_invoice_customer_id_foreign');
        });

        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_customer_id')->nullable()->default(null)->change();
            $table->foreign('ar_invoice_customer_id')->references('id')->on('ar_invoice')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_customer_product_ar_invoice_customer_id_foreign');
        });

        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_invoice_customer_id')->nullable(false)->change();
            $table->foreign('ar_invoice_customer_id')->references('id')->on('ar_invoice')->onDelete('cascade');
        });
    }
}
