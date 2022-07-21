<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    protected $connection = 'isp-system';

    public function up()
    {
        Schema::create('survey_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('pre_survey_reporting_id')->nullable()->default(null);
            $table->unsignedBigInteger('request_by')->nullable()->default(null);
            $table->unsignedBigInteger('branch_id')->nullable()->default(null);
            $table->date('request_date')->nullable()->default(null);
            $table->string('request_name')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('pre_survey_reporting_id')->references('id')->on('pre_survey_reporting')->onDelete('set null');
            $table->foreign('request_by')->references('id')->on('employee')->onDelete('set null');
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
        Schema::dropIfExists('survey_request');
    }
}
