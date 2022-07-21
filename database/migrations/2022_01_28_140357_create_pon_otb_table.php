<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePonOtbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pon_otb', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pon_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('otb_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('pon_id')->references('id')->on('pon')->onDelete('set null');
            $table->foreign('otb_id')->references('id')->on('otb')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pon_otb');
    }
}
