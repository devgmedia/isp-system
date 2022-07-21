<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProductAdditionalDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_product_additional_discount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('registration_date');
            $table->unsignedBigInteger('customer_product_additional_id')->nullable()->default(null);
            $table->unsignedBigInteger('customer_product_additional_discount_id')->nullable()->default(null);
            $table->date('start_date')->nullable()->default(null);
            $table->date('end_date')->nullable()->default(null);
            $table->tinyInteger('total_usage')->nullable()->default(null);
            $table->timestamps();

            $table->unique(
                ['customer_product_additional_id', 'customer_product_additional_discount_id'],
                'cus_pro_add_dis_cus_pro_add_id_cus_pro_add_dis_id_unique'
            );

            $table->foreign(
                'customer_product_additional_id',
                'cus_pro_add_dis_cus_pro_add_id_foreign',
            )->references('id')->on('customer_product_additional')->onDelete('set null');

            $table->foreign(
                'customer_product_additional_discount_id',
                'cus_pro_add_dis_cus_pro_add_dis_id_foreign',
            )->references('id')->on('customer_product_additional_discount')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_product_additional_discount');
    }
}
