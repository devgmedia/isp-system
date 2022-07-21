<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCustomerProductDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_customer_product_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('registration_date');
            $table->unsignedBigInteger('pre_customer_product_id')->nullable()->default(null);
            $table->unsignedBigInteger('product_discount_id')->nullable()->default(null);
            $table->date('start_date')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->tinyInteger('total_usage')->nullable()->default(null);
            $table->timestamps();

            $table->unique(['pre_customer_product_id', 'product_discount_id'], 'pre_cus_pro_dis_cus_pro_id_pro_dis_unique');

            $table->foreign('pre_customer_product_id')->references('id')->on('pre_customer_product')->onDelete('set null');
            $table->foreign('product_discount_id')->references('id')->on('product_discount')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_customer_product_discount');
    }
}
