<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerDiscountTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_discount', function (Blueprint $table) {
            $table->dropColumn('locked_by_bill');
            $table->dropUnique('customer_discount_discount_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_discount', function (Blueprint $table) {
            $table->boolean('locked_by_bill')->nullable()->default(false);
            $table->unique('discount_name');
        });
    }
}
