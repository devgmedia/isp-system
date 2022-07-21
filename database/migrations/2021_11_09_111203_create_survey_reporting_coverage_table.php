<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyReportingCoverageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_reporting_coverage', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->unsignedBigInteger('survey_reporting_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('media_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('media_vendor_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('olt_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('odp_id')->nullable()->default(NULL);
            $table->tinyInteger('odp_distance')->nullable()->default(null);
            $table->unsignedBigInteger('odp_distance_unit')->nullable()->default(NULL);
            $table->string('end_point')->nullable()->default(null);
            $table->tinyInteger('tower_hight')->nullable()->default(null);
            $table->unsignedBigInteger('tower_hight_unit')->nullable()->default(NULL);
            $table->tinyInteger('work_duration')->nullable()->default(null);
            $table->unsignedBigInteger('work_duration_unit')->nullable()->default(NULL); 
            $table->timestamps();      
           
            $table->unsignedBigInteger('bts_id')->nullable()->default(NULL);
            $table->tinyInteger('bts_distance')->nullable()->default(NULL);
            $table->unsignedBigInteger('tower_type_id')->nullable()->default(NULL);

            $table->string('note')->nullable()->default(NULL);
            $table->string('cable_type')->nullable()->default(NULL);  
       
            $table->unsignedTinyInteger('pole_7_meters')->nullable()->default(NULL);   
            $table->unsignedTinyInteger('pole_9_meters')->nullable()->default(NULL); 
 
            $table->foreign('survey_reporting_id')->references('id')->on('survey_reporting')->onDelete('set null'); 
            $table->foreign('media_id')->references('id')->on('internet_media')->onDelete('set null');
            $table->foreign('media_vendor_id')->references('id')->on('internet_media_vendor')->onDelete('set null');
            $table->foreign('olt_id')->references('id')->on('olt')->onDelete('set null');
            $table->foreign('odp_id')->references('id')->on('odp')->onDelete('set null');
            $table->foreign('odp_distance_unit')->references('id')->on('distance_unit')->onDelete('set null');
            $table->foreign('tower_hight_unit')->references('id')->on('height_unit')->onDelete('set null');
            $table->foreign('work_duration_unit')->references('id')->on('time_unit')->onDelete('set null');
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
        Schema::dropIfExists('survey_reporting_coverage');
    }
}
