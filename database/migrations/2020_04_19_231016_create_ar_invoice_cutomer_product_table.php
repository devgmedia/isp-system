<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArInvoiceCutomerProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_invoice_cutomer_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ar_invoice_customer_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('customer_product_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('ar_invoice_customer_id')->references('id')->on('ar_invoice_customer')->onDelete('set null');
            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ar_invoice_cutomer_product');
    }
}
