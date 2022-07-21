<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceCustomerProductDiscountP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_invoice_customer_product_discount', function (Blueprint $table) {
            $table->float('total', 15, 2)->nullable()->default(0);
            $table->float('total_usd', 15, 2)->nullable()->default(0);
            $table->float('total_sgd', 15, 2)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
