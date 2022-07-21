<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreSurveyRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_survey_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->unsignedBigInteger('pre_customer_prospective_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('request_by')->nullable()->default(NULL);
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->date('request_date')->nullable()->default(NULL);
            $table->string('request_name')->nullable()->default(NULL);
            $table->timestamps();

            $table->foreign('pre_customer_prospective_id')->references('id')->on('pre_customer_prospective')->onDelete('set null');
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
        Schema::dropIfExists('pre_survey_request');
    }
}
