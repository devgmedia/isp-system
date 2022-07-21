<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreSurveyReportingCoverageTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_survey_reporting_coverage', function (Blueprint $table) { 
            $table->unsignedBigInteger('bts_id')->nullable()->default(NULL);
            $table->tinyInteger('bts_distance')->nullable()->default(NULL);
            $table->unsignedBigInteger('tower_type_id')->nullable()->default(NULL);
            $table->string('note')->nullable()->default(NULL);
            $table->string('cable_type')->nullable()->default(NULL);  
            $table->foreign('bts_id')->references('id')->on('bts')->onDelete('set null'); 
            $table->foreign('tower_type_id')->references('id')->on('tower_type')->onDelete('set null'); 
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
