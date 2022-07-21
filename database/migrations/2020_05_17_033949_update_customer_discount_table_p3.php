<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerDiscountTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_discount', function (Blueprint $table) {
            $table->boolean('locked_by_bill')->nullable()->default(null);
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
            $table->dropColumn([
                'locked_by_bill',
            ]);
        }); 
    }
}
