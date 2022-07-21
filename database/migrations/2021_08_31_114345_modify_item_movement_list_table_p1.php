<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemMovementListTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id')->nullable()->default(null);
            $table->unsignedBigInteger('brand_product_id')->nullable()->default(null);

            $table->foreign('brand_product_id')->references('id')->on('item_brand_product')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('item_brand')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_movement_list', function (Blueprint $table) {
        });
    }
}
