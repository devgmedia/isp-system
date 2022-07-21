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
            $table->string('number')->nullable()->default(NULL)->unique();
            $table->string('photo')->nullable()->default(NULL);
            $table->string('official_photo')->nullable()->default(NULL);
            $table->boolean('active')->nullable()->default(FALSE);

            $table->unsignedBigInteger('sub_department_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('department_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('division_id')->nullable()->default(NULL);

            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('regional_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('company_id')->nullable()->default(NULL);
            
            $table->unsignedBigInteger('position_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('last_education')->nullable()->default(NULL);
            $table->unsignedBigInteger('religion_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('gender_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('blood_type_id')->nullable()->default(NULL);
            $table->string('birthplace')->nullable()->default(NULL);
            $table->date('birthdate')->nullable()->default(NULL);
            $table->unsignedBigInteger('marital_status_id')->nullable()->default(NULL);
            $table->unsignedTinyInteger('number_of_children')->nullable()->default(NULL);
            $table->date('hired_date')->nullable()->default(NULL);
            $table->date('fired_date')->nullable()->default(NULL);
            $table->string('npwp')->nullable()->default(NULL)->unique();
            $table->unsignedBigInteger('user_id')->nullable()->default(NULL);
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
