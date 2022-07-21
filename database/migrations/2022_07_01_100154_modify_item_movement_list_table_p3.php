<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemMovementListTableP3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->dropForeign('item_movement_list_pic_foreign');
        });

        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->dropColumn('to_pic');
        });

        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->unsignedBigInteger('to_pic')->nullable()->default(null);
            $table->foreign('to_pic')->references('id')->on('division')->onDelete('set null');
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
