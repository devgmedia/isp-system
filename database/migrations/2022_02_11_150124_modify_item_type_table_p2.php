<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyItemTypeTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_type', function (Blueprint $table) {
            $table->date('discontinue_date')->nullable()->default(null);
            $table->string('discontinue_name')->nullable()->default(null);
            $table->unsignedBigInteger('discontinue_by')->nullable()->default(null);

            $table->foreign('discontinue_by')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_type');
    }
}
