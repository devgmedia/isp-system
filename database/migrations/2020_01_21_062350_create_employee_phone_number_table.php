<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePhoneNumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_phone_number', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique();
            $table->unsignedBigInteger('type_id')->nullable()->default(null);
            $table->unsignedBigInteger('employee_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('employee_phone_number_type')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employee')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_phone_number');
    }
}
