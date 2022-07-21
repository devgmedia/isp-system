<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBtsContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('bts_contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->date('end_date')->nullable()->default(null);
            $table->string('document')->nullable()->defauilt(null);

            $table->unsignedBigInteger('bts_id')->nullable()->default(null);
            $table->foreign('bts_id')->references('id')->on('bts')->onDelete('set null');
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
        Schema::dropIfExists('bts_contract', function (Blueprint $table) {
            $table->foreign('bts_id')->references('id')->on('bts')->onDelete('set null');
        });
    }
}
