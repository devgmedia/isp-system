<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtbOdcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otb_odc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('odc_id')->nullable()->default(null);
            $table->unsignedBigInteger('otb_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('odc_id')->references('id')->on('odc')->onDelete('set null');
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
        Schema::dropIfExists('otb_odc');
    }
}
