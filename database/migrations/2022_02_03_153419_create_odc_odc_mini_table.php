<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdcOdcMiniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('odc_odc_mini', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('odc_id')->nullable()->default(null);
            $table->unsignedBigInteger('odc_mini_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('odc_id')->references('id')->on('odc')->onDelete('set null');
            $table->foreign('odc_mini_id')->references('id')->on('odc_mini')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('odc_odc_mini');
    }
}
