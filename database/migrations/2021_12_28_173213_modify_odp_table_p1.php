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
            $table->unsignedBigInteger('pon_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('otb_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('odc_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('odc_mini_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('area_id')->nullable()->default(NULL);

            $table->float('latitude', 20, 10)->nullable()->default(NULL);
            $table->float('longitude', 20, 10)->nullable()->default(NULL);
            $table->integer('capacity')->nullable()->default(NULL);
            $table->integer('usage')->nullable()->default(NULL);

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
