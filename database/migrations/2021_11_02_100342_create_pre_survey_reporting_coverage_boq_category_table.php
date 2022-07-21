<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSurveyReportingCoverageBoqCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_survey_reporting_coverage_boq_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->default(NULL); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_survey_reporting_coverage_boq_category');
    }
}
