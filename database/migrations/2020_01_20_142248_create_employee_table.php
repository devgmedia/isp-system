<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('number')->nullable()->default(null)->unique();
            $table->string('photo')->nullable()->default(null);
            $table->string('official_photo')->nullable()->default(null);
            $table->boolean('active')->nullable()->default(false);

            $table->unsignedBigInteger('sub_department_id')->nullable()->default(null);
            $table->unsignedBigInteger('department_id')->nullable()->default(null);
            $table->unsignedBigInteger('division_id')->nullable()->default(null);

            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->unsignedBigInteger('regional_id')->nullable()->default(null);
            $table->unsignedBigInteger('company_id')->nullable()->default(null);

            $table->unsignedBigInteger('position_id')->nullable()->default(null);
            $table->unsignedBigInteger('last_education')->nullable()->default(null);
            $table->unsignedBigInteger('religion_id')->nullable()->default(null);
            $table->unsignedBigInteger('gender_id')->nullable()->default(null);
            $table->unsignedBigInteger('blood_type_id')->nullable()->default(null);
            $table->string('birthplace')->nullable()->default(null);
            $table->date('birthdate')->nullable()->default(null);
            $table->unsignedBigInteger('marital_status_id')->nullable()->default(null);
            $table->unsignedTinyInteger('number_of_children')->nullable()->default(null);
            $table->date('hired_date')->nullable()->default(null);
            $table->date('fired_date')->nullable()->default(null);
            $table->string('npwp')->nullable()->default(null)->unique();
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('sub_department_id')->references('id')->on('sub_department')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('department')->onDelete('set null');
            $table->foreign('division_id')->references('id')->on('division')->onDelete('set null');

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
            $table->foreign('regional_id')->references('id')->on('religion')->onDelete('set null');
            $table->foreign('company_id')->references('id')->on('religion')->onDelete('set null');

            $table->foreign('position_id')->references('id')->on('position')->onDelete('set null');
            $table->foreign('last_education')->references('id')->on('education')->onDelete('set null');
            $table->foreign('religion_id')->references('id')->on('religion')->onDelete('set null');
            $table->foreign('gender_id')->references('id')->on('gender')->onDelete('set null');
            $table->foreign('blood_type_id')->references('id')->on('blood_type')->onDelete('set null');
            $table->foreign('marital_status_id')->references('id')->on('marital_status')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee');
    }
}
