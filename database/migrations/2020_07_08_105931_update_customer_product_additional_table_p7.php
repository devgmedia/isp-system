<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerProductAdditionalTableP7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->boolean('adjusted_price')->nullable()->default(false);
            $table->unsignedInteger('special_price')->nullable()->dafault(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_product_additional', function (Blueprint $table) {
            $table->dropColumn([
                'adjusted_price',
                'special_price',
            ]);
        });
    }
}
