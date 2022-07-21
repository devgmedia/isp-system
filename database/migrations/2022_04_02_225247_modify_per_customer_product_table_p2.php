<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPerCustomerProductTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('pre_customer_product', function (Blueprint $table) {
            $table->string('sid')->nullable()->default(null);
            $table->boolean('public_facility')->nullable()->default(false);

            $table->boolean('tax')->nullable()->default(false);
            $table->string('product_name')->nullable()->default(null);
            $table->unsignedInteger('product_price')->nullable()->default(0);
            $table->unsignedInteger('product_price_usd')->nullable()->default(0);
            $table->unsignedInteger('product_price_sgd')->nullable()->default(0);
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
