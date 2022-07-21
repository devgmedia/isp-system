<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_movement_list', function (Blueprint $table) {
            $table->unsignedBigInteger('pic')->nullable()->default(null);
            $table->foreign('pic')->references('id')->on('spm')->onDelete('set null');

            $table->unsignedBigInteger('from_ownership_bts_id')->nullable()->default(null);
            $table->foreign('from_ownership_bts_id')->references('id')->on('bts')->onDelete('set null');

            $table->unsignedBigInteger('from_location_bts_id')->nullable()->default(null);
            $table->foreign('from_location_bts_id')->references('id')->on('bts')->onDelete('set null');

            $table->unsignedBigInteger('to_ownership_bts_id')->nullable()->default(null);
            $table->foreign('to_ownership_bts_id')->references('id')->on('bts')->onDelete('set null');

            $table->unsignedBigInteger('to_location_bts_id')->nullable()->default(null);
            $table->foreign('to_location_bts_id')->references('id')->on('bts')->onDelete('set null');
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
