<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemMovementListTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->unsignedBigInteger('item_class_id')->nullable()->default(null);
            $table->foreign('item_class_id')->references('id')->on('item_class')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_movement_list');
    }
}
