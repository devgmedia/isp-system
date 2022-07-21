<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAddressHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_address_has_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('address_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('tag_id')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('employee_address')->onDelete('set null');
            $table->foreign('tag_id')->references('id')->on('employee_address_tag')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_address_has_tag');
    }
}
