<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPerCustomerProductDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer_product_discount', function (Blueprint $table) {
            $table->string('discount_name')->nullable()->default(null);
            $table->unsignedInteger('discount_price')->nullable()->default(0);
            $table->unsignedInteger('discount_price_usd')->nullable()->default(0);
            $table->unsignedInteger('discount_price_sgd')->nullable()->default(0);            
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
