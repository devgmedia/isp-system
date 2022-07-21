<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOdpTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('odp', function (Blueprint $table) {
            $table->unsignedBigInteger('pon_id')->nullable()->default(null);
            $table->unsignedBigInteger('otb_id')->nullable()->default(null);
            $table->unsignedBigInteger('odc_id')->nullable()->default(null);
            $table->unsignedBigInteger('odc_mini_id')->nullable()->default(null);
            $table->unsignedBigInteger('area_id')->nullable()->default(null);

            $table->float('latitude', 20, 10)->nullable()->default(null);
            $table->float('longitude', 20, 10)->nullable()->default(null);
            $table->integer('capacity')->nullable()->default(null);
            $table->integer('usage')->nullable()->default(null);

            $table->foreign('pon_id')->references('id')->on('pon')->onDelete('set null');
            $table->foreign('otb_id')->references('id')->on('otb')->onDelete('set null');
            $table->foreign('odc_id')->references('id')->on('odc')->onDelete('set null');
            $table->foreign('odc_mini_id')->references('id')->on('odc_mini')->onDelete('set null');
            $table->foreign('area_id')->references('id')->on('area')->onDelete('set null');
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
