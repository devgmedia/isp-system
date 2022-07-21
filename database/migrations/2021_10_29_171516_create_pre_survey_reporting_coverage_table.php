<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSurveyReportingCoverageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::create('pre_survey_reporting_coverage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pre_survey_reporting_id')->nullable()->default(null);
            $table->unsignedBigInteger('media_id')->nullable()->default(null);
            $table->unsignedBigInteger('media_vendor_id')->nullable()->default(null);
            $table->unsignedBigInteger('olt_id')->nullable()->default(null);
            $table->unsignedBigInteger('odp_id')->nullable()->default(null);
            $table->tinyInteger('odp_distance')->nullable()->default(null);
            $table->unsignedBigInteger('odp_distance_unit')->nullable()->default(null);
            $table->string('end_point')->nullable()->default(null);
            $table->tinyInteger('tower_hight')->nullable()->default(null);
            $table->unsignedBigInteger('tower_hight_unit')->nullable()->default(null);
            $table->tinyInteger('work_duration')->nullable()->default(null);
            $table->unsignedBigInteger('work_duration_unit')->nullable()->default(null);

            $table->timestamps();

            $table->foreign('pre_survey_reporting_id')->references('id')->on('pre_survey_reporting')->onDelete('set null');
            $table->foreign('media_id')->references('id')->on('internet_media')->onDelete('set null');
            $table->foreign('media_vendor_id')->references('id')->on('internet_media_vendor')->onDelete('set null');
            $table->foreign('olt_id')->references('id')->on('olt')->onDelete('set null');
            $table->foreign('odp_id')->references('id')->on('odp')->onDelete('set null');
            $table->foreign('odp_distance_unit')->references('id')->on('distance_unit')->onDelete('set null');
            $table->foreign('tower_hight_unit')->references('id')->on('height_unit')->onDelete('set null');
            $table->foreign('work_duration_unit')->references('id')->on('time_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_survey_reporting_coverage');
    }
}
