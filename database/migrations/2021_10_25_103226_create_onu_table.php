<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('item_id')->nullable()->default(null);
            $table->unsignedBigInteger('olt_id')->nullable()->default(null);
            $table->string('name')->unique();
            $table->string('ip')->unique();
            $table->tinyInteger('total_port')->nullable()->default(null);
            $table->tinyInteger('total_ssid')->nullable()->default(null);
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
        Schema::dropIfExists('onu');
    }
}
