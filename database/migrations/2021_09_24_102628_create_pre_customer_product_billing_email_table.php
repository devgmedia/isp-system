<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerProductBillingEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_customer_product_billing_email', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pre_customer_product_id')->nullable()->default(NULL);
            $table->string('name')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('pre_customer_product_id','pre_cus_pro_id')->references('id')->on('pre_customer_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer_product_billing_email');
    }
}
