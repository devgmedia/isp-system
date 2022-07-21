<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSurveyReportingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_survey_reporting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique(); 
            $table->unsignedBigInteger('pre_survey_tasking_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(NULL);  
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->timestamps();
  
            $table->foreign('pre_survey_tasking_id')->references('id')->on('pre_survey_tasking')->onDelete('set null');
            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null'); 
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_survey_reporting');
    }
}
