<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreSurveyReportingCoverageTableP2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_survey_reporting_coverage', function (Blueprint $table) {  
            $table->unsignedTinyInteger('pole_7_meters')->nullable()->default(NULL);   
            $table->unsignedTinyInteger('pole_9_meters')->nullable()->default(NULL); 
             
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
