<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductAdditionalDiscountTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product_additional_discount', function (Blueprint $table) {
            $table->boolean('corrected')->nullable()->default(false);
            $table->dropColumn('locked_by_bill');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product_additional_discount', function (Blueprint $table) {
            $table->dropColumn('corrected');
            $table->boolean('locked_by_bill')->nullable()->default(null);
        });
    }
}