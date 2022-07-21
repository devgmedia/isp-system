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
    public function up()
    {
        Schema::create('bts_contract', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->date('end_date')->nullable()->default(NULL);
            $table->string('document')->nullable()->defauilt(NULL);

            $table->unsignedBigInteger('bts_id')->nullable()->default(NULL);
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
        Schema::dropIfExists('bts_contract', function (Blueprint $table){

            $table->foreign('bts_id')->references('id')->on('bts')->onDelete('set null');
        });
        
    }
}
