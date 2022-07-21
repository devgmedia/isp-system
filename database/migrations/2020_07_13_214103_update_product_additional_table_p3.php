<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductAdditionalTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_additional', function (Blueprint $table) {
            $table->boolean('quantity_can_be_adjusted')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_additional', function (Blueprint $table) {
            $table->dropColumn('quantity_can_be_adjusted');
        });
    }
}
