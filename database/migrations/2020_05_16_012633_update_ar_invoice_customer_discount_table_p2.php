<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArInvoiceCustomerDiscountTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_discount', function (Blueprint $table) {
            $table->string('customer_discount_name')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_invoice_customer_discount', function (Blueprint $table) {
            $table->dropColumn('customer_discount_name');
        });
    }
}
