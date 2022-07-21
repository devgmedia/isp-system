<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPreSurveyReportingCoverageRabItemTableP1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp_system';

    public function up()
    {
        Schema::table('pre_survey_reporting_coverage_rab_item', function (Blueprint $table) {
            $table->dropForeign('pre_sur_rep_cov_id_foreign');
        });

        Schema::table('pre_survey_reporting_coverage_rab_item', function (Blueprint $table) {
            $table->dropUnique('pre_sur_rep_cov_rab_itm_unique');
        });

        Schema::table('pre_survey_reporting_coverage_rab_item', function (Blueprint $table) {
            $table->foreign('pre_survey_reporting_coverage_id', 'pre_sur_rep_cov_id_foreign')->references('id')->on('pre_survey_reporting_coverage')->onDelete('set null');
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
