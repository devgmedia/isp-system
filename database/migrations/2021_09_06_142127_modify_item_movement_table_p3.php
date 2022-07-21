<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemMovementTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->unsignedBigInteger('from_movement_category_id')->nullable()->default(null);
            $table->unsignedBigInteger('to_movement_category_id')->nullable()->default(null);

            $table->foreign('from_movement_category_id')->references('id')->on('item_movement_category')->onDelete('set null');
            $table->foreign('to_movement_category_id')->references('id')->on('item_movement_category')->onDelete('set null');
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
