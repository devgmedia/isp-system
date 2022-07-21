<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOpnameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_opname', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('available')->nullable()->default(null);
            $table->integer('total')->nullable()->default(null);
            $table->unsignedBigInteger('item_type_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('item_type_id')->references('id')->on('item_type')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_opname');
    }
}