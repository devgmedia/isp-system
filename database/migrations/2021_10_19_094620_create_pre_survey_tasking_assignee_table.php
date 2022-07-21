<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSurveyTaskingAssigneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_survey_tasking_assignee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pre_survey_tasking_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('assignor')->nullable()->default(NULL); 
            $table->unsignedBigInteger('assignee')->nullable()->default(NULL);  
            $table->timestamps();

            $table->foreign('pre_survey_tasking_id')->references('id')->on('pre_survey_tasking')->onDelete('set null'); 
            $table->foreign('assignor')->references('id')->on('employee')->onDelete('set null'); 
            $table->foreign('assignee')->references('id')->on('employee')->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_survey_tasking_assignee');
    }
}
