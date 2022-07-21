<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_product_payment', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('customer_product_id')->nullable()->default(null);
            $table->foreign('customer_product_id')->references('id')->on('customer_product')->onDelete('set null');
            
            $table->unsignedBigInteger('cash_bank_id')->nullable()->default(null);
            $table->foreign('cash_bank_id')->references('id')->on('cash_bank')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product_payment');
    }
}
