<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCustomerProductAdditionalTableP8 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->dropForeign('customer_product_additional_dependency_foreign');
        });

        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->dropColumn('dependency');
            $table->dropColumn('first_month_not_billed');
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
