<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSvlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('svlan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->string('id_svlan')->unique();
            $table->string('id_cvlan');
            $table->string('mgmt_ip')->unique();
            $table->unsignedBigInteger('pon_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('pon_id')->references('id')->on('pon')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('svlan');
    }
}
