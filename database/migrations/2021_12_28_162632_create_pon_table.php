<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->integer('device_number');
            $table->integer('device_row_number');
            $table->integer('device_row_port_number');
            $table->unsignedBigInteger('olt_id')->nullable()->default(null);
            $table->string('uuid');
            $table->timestamps();

            $table->foreign('olt_id')->references('id')->on('olt')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pon');
    }
}
