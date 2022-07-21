<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerProductTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->dropForeign('ar_invoice_customer_product_ar_invoice_customer_id_foreign');
        });

        Schema::table('ar_invoice_customer_product', function (Blueprint $table) {
            $table->foreign('ar_invoice_customer_id')->references('id')->on('ar_invoice_customer')->onDelete('cascade');
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
            $table->foreign('ar_invoice_customer_id')->references('id')->on('ar_invoice_customer')->onDelete('set null');
        });
    }
}
