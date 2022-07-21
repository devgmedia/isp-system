<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTableP15 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item', function (Blueprint $table) {
            $table->unsignedBigInteger('item_condition_id')->nullable()->default(null);
            $table->unsignedBigInteger('item_condition_category_id')->nullable()->default(null);

            $table->foreign('item_condition_id')->references('id')->on('item_condition')->onDelete('set null');
            $table->foreign('item_condition_category_id')->references('id')->on('item_condition_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
