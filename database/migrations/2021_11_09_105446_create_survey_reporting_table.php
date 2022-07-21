<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyReportingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_reporting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique(); 
            $table->unsignedBigInteger('survey_tasking_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('pre_customer_id')->nullable()->default(NULL);  
            $table->unsignedBigInteger('branch_id')->nullable()->default(NULL);
            $table->timestamps();
  
            $table->foreign('survey_tasking_id')->references('id')->on('survey_tasking')->onDelete('set null');
            $table->foreign('pre_customer_id')->references('id')->on('pre_customer')->onDelete('set null'); 
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('set null');

            $table->string('content')->nullable()->default(NULL);  
            $table->string('owncloud_link')->nullable()->default(NULL);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_reporting');
    }
}
