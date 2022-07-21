<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBtsInterfaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('bts_interface', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bts_id')->nullable()->default(null);
            $table->foreign('bts_id')->references('id')->on('bts')->onDelete('set null');

            $table->unsignedInteger('bandwidth')->nullable()->defauil(null);
            $table->unsignedBigInteger('bandwidth_unit_id')->nullable()->default(null);
            $table->foreign('bandwidth_unit_id')->references('id')->on('bandwidth_unit')->onDelete('set null');

            $table->unsignedBigInteger('bandwidth_type_id')->nullable()->default(null);
            $table->foreign('bandwidth_type_id')->references('id')->on('bandwidth_type')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bts_interface');
    }
}
