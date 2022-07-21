<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPerCustomerProductAdditionalTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_customer_product_additional', function (Blueprint $table) {
            $table->string('sid')->nullable()->default(null);

            $table->string('additional_name')->nullable()->default(null);
            $table->unsignedInteger('additional_price')->nullable()->default(0);
            $table->unsignedInteger('additional_price_usd')->nullable()->default(0);
            $table->unsignedInteger('additional_price_sgd')->nullable()->default(0);
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
