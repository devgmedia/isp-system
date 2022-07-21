<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyArInvoiceBillingTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('ar_invoice_billing', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_product_payment_id')->nullable()->default(null);
            $table->foreign('customer_product_payment_id')->references('id')->on('customer_product_payment')->onDelete('set null');
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
