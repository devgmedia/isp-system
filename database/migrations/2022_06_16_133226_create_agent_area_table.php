<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_area', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->unsignedBigInteger('province_id')->nullable()->default(null);
            $table->foreign('province_id')->references('id')->on('province')->onDelete('set null');
            
            $table->unsignedBigInteger('district_id')->nullable()->default(null);
            $table->foreign('district_id')->references('id')->on('district')->onDelete('set null');
            
            $table->unsignedBigInteger('sub_district_id')->nullable()->default(null);
            $table->foreign('sub_district_id')->references('id')->on('sub_district')->onDelete('set null');
            
            $table->unsignedBigInteger('village_id')->nullable()->default(null);
            $table->foreign('village_id')->references('id')->on('village')->onDelete('set null');
            
            $table->string('postal_code')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');

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
        //
    }
}
